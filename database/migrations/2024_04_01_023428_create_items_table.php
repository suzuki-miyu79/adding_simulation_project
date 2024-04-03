<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_category_id')->constrained();
            $table->foreignId('condition_id')->constrained();
            $table->string('name', 191);
            $table->text('description');
            $table->decimal('price', 10, 0);
            $table->string('image', 255);
            $table->foreignId('seller_user_id')->constrained('users');
            $table->foreignId('buyer_user_id')->constrained('users');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
