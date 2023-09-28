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
            $table->string("product_code")->unique()->nullable();
            $table->string("product_name")->unique();
            $table->unsignedBigInteger("product_price");
            $table->longText("product_image")->nullable();
            $table->tinyInteger("product_active")->default(0);
            $table->unsignedBigInteger("product_created_by")->nullable();
            $table->unsignedBigInteger("product_modified_by")->nullable();

            $table->foreign("product_created_by")->references("id")->on("users");
            $table->foreign("product_modified_by")->references("id")->on("users");

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
