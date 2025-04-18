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
        Schema::create('q_rcodes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->index();
            $table->foreignId('equipment_type_id')->constrained('equipment_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('q_rcodes');
    }
};
