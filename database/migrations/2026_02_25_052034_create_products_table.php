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
            $table->id(); // លេខសម្គាល់ផលិតផល
            $table->string('product_name');
            $table->string('category'); // ប្រភេទផលិតផល
            $table->text('description')->nullable(); // ការពិពណ៌នា
            $table->decimal('price', 10, 2); // តម្លៃផលិតផល
            $table->integer('quantity'); // ចំនួនស្តុក
            $table->string('brand')->nullable(); // ម៉ាកផលិតផល
            $table->string('image')->nullable(); // រូបភាពផលិតផល
            $table->boolean('status')->default(1); // ស្ថានភាព 1=បង្ហាញ, 0=មិនបង្ហាញ
            $table->timestamps();

            // Foreign key
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
