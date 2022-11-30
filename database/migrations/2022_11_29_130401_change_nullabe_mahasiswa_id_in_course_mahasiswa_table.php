<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullabeMahasiswaIdInCourseMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_mahasiswas', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
        });

        Schema::table('course_mahasiswas', function (Blueprint $table) {
            $table->foreignId('mahasiswa_id')->nullable()->change()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_mahasiswas', function (Blueprint $table) {
            $table->foreignId('mahasiswa_id')->nullable(false)->change();
        });
    }
}
