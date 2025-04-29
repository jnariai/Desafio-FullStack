<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('desenvolvedores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nivel_id');
            $table->string('nome');
            $table->string('sexo', 1);
            $table->string('data_nascimento');
            $table->string('hobby');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('desenvolvedores');
    }
};
