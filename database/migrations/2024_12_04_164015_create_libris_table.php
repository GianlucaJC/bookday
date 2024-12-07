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
        Schema::create('libri', function (Blueprint $table) {
            $table->id();
            $table->string('nome_libro',100);
            $table->text('descrizione_libro');
            $table->string('url_foto');
            $table->double('prezzo',10,2);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libri');
    }
};
