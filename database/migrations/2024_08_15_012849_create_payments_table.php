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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('admin_user');
            $table->foreign('admin_user')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('finance_id');
            $table->foreign('finance_id')->references('id')->on('finances')->onDelete('cascade');
            $table->dateTime('payment_date', $precision = 0);
            $table->float('capital_amount', 10, 2);
            $table->float('interest_amount', 10, 2);
            $table->float('total_amount', 10, 2);
            $table->string('note');
            $table->string('support');
            $table->string('status');
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
