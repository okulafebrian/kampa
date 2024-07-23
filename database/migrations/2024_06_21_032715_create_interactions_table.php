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
        Schema::create('interactions', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['answered', 'call back', 'not interested', 'not home', 'inaccessible']);
            $table->integer('support_level')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('contact_id')->constrained();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('organization_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interactions');
    }
};
