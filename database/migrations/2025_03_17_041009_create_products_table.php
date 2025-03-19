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
            $table->foreignIdFor(\App\Models\Admin\Category::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique('name');
            $table->text('description');
            $table->string('price');
            $table->string('image');
            $table->boolean('featured')->default(false)->nullable(false);
            // $table->string('quantity');
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
