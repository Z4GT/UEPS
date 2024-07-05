<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id('id_resource');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('id_pro');
            $table->string('id_task');
            $table->timestamps();

            // Definir las claves foráneas
            $table->foreign('id_pro')->references('id_pro')->on('projects')->onDelete('cascade');
            $table->foreign('id_task')->references('id_task')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
