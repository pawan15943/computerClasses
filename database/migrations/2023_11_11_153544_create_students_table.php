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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('student_uid')->nullable();
            $table->boolean('is_paid')->default('0');
            $table->boolean('is_certificate')->default('0');
            
            $table->string('center')->nullable();
            $table->string('total_course_fees')->nullable();
            $table->string('paid_amount')->nullable();
            $table->string('pending_amount')->nullable();
         
            $table->string('payment_option');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('class_id');
            $table->boolean('status')->default('0');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            $table->foreign('course_id')
            ->references('id')
            ->on('courses')
            ->onDelete('cascade');
            $table->foreign('class_id')
            ->references('id')
            ->on('grades')
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['user_id']);
            $table->dropForeign(['course_id']);
        });
        Schema::dropIfExists('students');
    }
};
