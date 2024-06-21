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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('product_Code')->nullable(); // Add 'squ' column without unique constraint
        });

        // Generate and assign unique values for the 'squ' column
        $products = \App\Models\Product::all();
        foreach ($products as $index => $product) {
            $product->squ = $index + 1; // Assign a unique value (e.g., incrementing)
            $product->save();
        }

        // Set 'squ' column as unique after assigning values
        Schema::table('products', function (Blueprint $table) {
            $table->integer('product_Code')->unique()->change(); // Change 'squ' column to unique
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('product_Code'); 
        });
    }
};
