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
        Schema::create('courses', function (Blueprint $table) {
       
            $table->id();
            $table->string('course_name');
            $table->string('course_fees');
            $table->string('discount')->nullable();
            $table->string('course_code');
            $table->string('discount_fees')->nullable();
            $table->string('installment_1')->nullable();
            $table->string('installment_2')->nullable();
            $table->string('installment_3')->nullable();
            $table->string('lumpsum')->nullable();
            $table->string('syllabus')->nullable();
            $table->string('shedule')->nullable();
            $table->string('duration');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
