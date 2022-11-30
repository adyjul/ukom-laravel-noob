<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalKolaboratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_kolaborators', function (Blueprint $table) {
            // MUST HAVE
            $table->id();
            // MUST HAVE
          
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('proposal_id')->contrained()->onDelete('cascade');

             // MUST HAVE
             $table->timestamps();
             // MUST HAVE

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposal_kolaborators');
    }
}
