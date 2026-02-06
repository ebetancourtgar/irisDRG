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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            $table->string('name'); //Kyocera Task Alfa
            $table->string('barcode')->unique()->index(); //759002312
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade'); //id=1 (Kyocera)
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');//id = 2 (Multifuncional)
            $table->string('part_number')->nullable(); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
