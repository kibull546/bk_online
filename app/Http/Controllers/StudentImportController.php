<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class StudentImportController extends Controller
{
    public function showForm()
    {
        if (!Auth::check() || Auth::user()->role != 'admin') {
            return redirect('/login-admin');
        }

        return view('student-import');
    }

    public function import(Request $request)
    {
        if (!Auth::check() || Auth::user()->role != 'admin') {
            return redirect('/login-admin');
        }

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();

            if ($ext == 'csv') {
                $data = array_map('str_getcsv', file($file->getRealPath()));
            } else {
                $data = $this->readExcel($file->getRealPath());
            }

            $imported = 0;
            $errors = [];
            $generatedCodes = [];

            for ($i = 1; $i < count($data); $i++) {
                $row = $data[$i];

                if (empty($row[0]) || empty($row[1]) || empty($row[2])) {
                    $errors[] = "Baris " . ($i + 1) . ": Data tidak lengkap";
                    continue;
                }

                $name = trim($row[0]);
                $email = trim($row[1]);
                $phone = trim($row[2]);

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Baris " . ($i + 1) . ": Email '$email' tidak valid";
                    continue;
                }

                // 🔥 CEK DUPLICATE
                $existingUser = User::where('email', $email)->first();

                if ($existingUser) {
                    // 🔥 RESET PASSWORD
                    $newPassword = 'Murid@' . substr(md5($email), 0, 6);

                    $existingUser->update([
                        'password' => Hash::make($newPassword)
                    ]);

                    $generatedCodes[] = [
                        'name' => $existingUser->name,
                        'email' => $existingUser->email,
                        'student_code' => $existingUser->student_code,
                        'password' => $newPassword,
                        'status' => 'Password direset'
                    ];

                    continue;
                }

                // Generate kode siswa
                $studentCode = strtoupper(Str::random(6));
                while (User::where('student_code', $studentCode)->exists()) {
                    $studentCode = strtoupper(Str::random(6));
                }

                // Generate password
                $defaultPassword = 'Murid@' . substr(md5($email), 0, 6);

                try {
                    User::create([
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'password' => Hash::make($defaultPassword),
                        'role' => 'murid',
                        'student_code' => $studentCode,
                    ]);

                    $generatedCodes[] = [
                        'name' => $name,
                        'email' => $email,
                        'student_code' => $studentCode,
                        'password' => $defaultPassword,
                        'status' => 'Berhasil'
                    ];

                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Baris " . ($i + 1) . ": " . $e->getMessage();
                }
            }

            return view('student-import-result', compact('imported', 'errors', 'generatedCodes'));

        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    private function readExcel($filePath)
    {
        $data = [];

        try {
            if (extension_loaded('zip')) {
                $data = $this->readXlsx($filePath);
            } else {
                $data = array_map('str_getcsv', file($filePath));
            }
        } catch (\Exception $e) {
            $data = [];
        }

        return $data;
    }

    private function readXlsx($filePath)
    {
        $data = [];

        try {
            $zip = new \ZipArchive();
            if ($zip->open($filePath) === TRUE) {
                $xml = $zip->getFromName('xl/worksheets/sheet1.xml');
                $zip->close();

                if ($xml) {
                    $data = $this->parseXmlWorksheet($xml);
                }
            }
        } catch (\Exception $e) {
            $data = [];
        }

        return $data;
    }

    private function parseXmlWorksheet($xml)
    {
        $data = [];

        try {
            $xml_obj = simplexml_load_string($xml);

            foreach ($xml_obj->sheetData->row as $row) {
                $rowData = [];
                foreach ($row->c as $cell) {
                    $rowData[] = (string)$cell->v;
                }
                $data[] = $rowData;
            }
        } catch (\Exception $e) {}

        return $data;
    }

    public function downloadTemplate()
    {
        $fileName = 'template_siswa.csv';
        $file = fopen('php://memory', 'w');

        fputcsv($file, ['Nama Siswa', 'Email', 'Nomor Telepon']);
        fputcsv($file, ['Ujang', 'ujang@example.com', '08123456789']);
        fputcsv($file, ['Jajang', 'jajang@example.com', '08234567890']);

        rewind($file);
        $csv = stream_get_contents($file);
        fclose($file);

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}