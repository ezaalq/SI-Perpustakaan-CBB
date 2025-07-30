<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('petugas', function (Blueprint $table) {
            $table->softDeletes(); // akan membuat kolom `deleted_at` bertipe datetime nullable
        });
    }

    public function down()
    {
        Schema::table('petugas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
