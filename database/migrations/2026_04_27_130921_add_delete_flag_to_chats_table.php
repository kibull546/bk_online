<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('chats', function (Blueprint $table) {
    $table->boolean('deleted_by_siswa')->default(false);
    $table->boolean('deleted_by_guru')->default(false);
});
    }

    public function down()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn(['deleted_by_siswa', 'deleted_by_guru']);
        });
    }
};