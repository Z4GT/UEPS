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
        Schema::create('projects', function (Blueprint $table) {
            $table->string('id_pro')->primary();
            $table->string('id_responsible');
            $table->string('name');
            $table->text('description');
            $table->string('status');
            $table->float('progress');
            $table->date('start_date');
            $table->date('end_date');
            $table->float('budget');
            $table->string('image')->nullable();
            $table->timestamps();

            // Índices adicionales
            $table->index('id_responsible');

            // Relaciones
            $table->foreign('id_responsible')->references('id_responsible')->on('responsibles')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
