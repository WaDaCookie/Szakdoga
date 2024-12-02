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
        Schema::create('equipment_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_number')->unique();
            $table->string('status')->nullable();
            $table->foreignId('room_id')->nullable()->constrained('rooms');
            $table->foreignId('equipment_id')->constrained('equipments');
            $table->unique(['room_id', 'equipment_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_types');
    }
};
