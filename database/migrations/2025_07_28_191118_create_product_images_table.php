<?php

use App\Enums\ProductImagePositionEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->string('image', 255)->unique();
            $table->enum('position', ProductImagePositionEnum::values())->default('gallery')->index;
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete()->index;
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
