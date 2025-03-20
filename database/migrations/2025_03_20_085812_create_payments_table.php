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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Order::class,'order_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\User::class,'user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount',10,2);
            $table->enum('status',['pending','completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
