<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('anggota_siswa', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('anggota_non_siswa', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('buku', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('pinjam_header_siswa', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('pinjam_header_non_siswa', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('anggota_siswa', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('anggota_non_siswa', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('buku', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('pinjam_header_siswa', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('pinjam_header_non_siswa', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
