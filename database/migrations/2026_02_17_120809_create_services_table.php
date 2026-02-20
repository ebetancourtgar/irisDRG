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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title'); 
            $table->text('description')->nullable(); 
            $table->string('service_type'); 
            $table->dateTime('scheduled_at'); 
            $table->string('status')->default('pendiente'); 
            $table->string('cliente')->nullable();
            $table->string('folio')->nullable();

            $table->foreignId('technician_id')->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('branch_id')->constrained('branches');

            $table->dateTime('started_at')->nullable(); 
            $table->dateTime('finished_at')->nullable();


            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
