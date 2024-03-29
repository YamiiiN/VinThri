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
        Schema::create('feedback', function (Blueprint $table) {
            $table->bigIncrements('feedback_id'); 
            $table->string('date');
            $table->string('images');
            $table->text('comment');
            $table->timestamps();

            $table->unsignedBigInteger('order_item_id');
            $table->foreign('order_item_id')->references('order_item_id')->on('order_items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
