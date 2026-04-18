<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('buses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ligne_id')->constrained()->onDelete('cascade');
            $table->string('numero_bus')->unique();
            $table->enum('etat', ['actif', 'hors_service'])->default('actif');
            $table->boolean('occupe')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('buses');
    }
};
