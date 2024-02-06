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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('fee_amount');
            $table->string('installment');
            $table->string('transaction_id');
            $table->date('transaction_date');
            $table->string('received_amount')->nullable();
           
            $table->string('payment_mode');
            $table->boolean('is_varified')->default('0');
            $table->string('reciept');
            $table->string('acknowledgement_receipt')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('student_id')
            ->references('id')
            ->on('students')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
