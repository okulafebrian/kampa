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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('dob')->nullable();
            $table->foreignId('house_id')->constrained();
            $table->foreignId('employment_id')->constrained();
            $table->foreignId('polling_station_id')->nullable()->constrained();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_volunteer')->default(false);
            $table->boolean('is_witness')->default(false);
            $table->boolean('is_deceased')->default(false);
            $table->foreignId('organization_id')->constrained();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
