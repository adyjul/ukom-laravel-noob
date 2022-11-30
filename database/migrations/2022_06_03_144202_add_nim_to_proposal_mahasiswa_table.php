<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNimToProposalMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposal_mahasiswas', function (Blueprint $table) {
            $table->string('nim')->nullable()->after('mahasiswa_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proposal_mahasiswas', function (Blueprint $table) {
            $table->dropColumn('nim');
        });
    }
}
