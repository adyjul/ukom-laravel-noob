<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
             // MUST HAVE
             $table->id();
             // MUST HAVE

             $table->string('name');
             $table->longText('description');
             $table->longText('student_achievement');
             $table->text('proposal')->nullable();
             $table->json('registration_date')->nullable();
             $table->json('activity_date')->nullable();
             $table->float('lesson_hours')->nullable();
             $table->integer('quota')->nullable();
             $table->longText('learning_achievement')->nullable();
             $table->foreignId('dudi_id')->nullable()->constrained()->onDelete('cascade');
             $table->unsignedBigInteger('prodi_id');
             $table->integer('validation_status')->nullable();
             $table->text('validation_message')->nullable();


             // MUST HAVE
             $table->unsignedBigInteger('created_by');
             $table->unsignedBigInteger('updated_by');
             $table->unsignedBigInteger('deleted_by');
             $table->unsignedBigInteger('restored_by');
             $table->timestamps();
             $table->softDeletes();
             $table->dateTime('restored_at')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
