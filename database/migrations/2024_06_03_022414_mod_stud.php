<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('mod_stud', function (Blueprint $table) {
            $table->string('id_stud');
            $table->string('id_mod');
            $table->primary(['id_stud', 'id_mod']);
            $table->timestamps();

            // Índices adicionales
            $table->index('id_mod');
            $table->index('id_stud');

            // Relaciones
            $table->foreign('id_mod')->references('id_mod')->on('modules')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_stud')->references('id_stud')->on('students')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mod_stud');
    }
};
