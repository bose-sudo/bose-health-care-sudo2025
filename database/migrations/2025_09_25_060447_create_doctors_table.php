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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('doctor_id')->unique(); // auto-generated code
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // link to user
            $table->string('first_name');
            $table->string('last_name');
            $table->string('specialization')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
