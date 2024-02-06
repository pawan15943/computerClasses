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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('father_name')->nullable();
            $table->string('suggestion_method')->nullable();
            $table->string('suggested_person_name')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            $table->foreign('country_id')
            ->references('id')
            ->on('countries')
            ->onDelete('cascade');
            $table->foreign('state_id')
            ->references('id')
            ->on('states')
            ->onDelete('cascade');
            $table->foreign('city_id')
            ->references('id')
            ->on('cities')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['user_id']);
            $table->dropForeign(['countries']);
            $table->dropForeign(['states']);
            $table->dropForeign(['cities']);
          
        });
        Schema::dropIfExists('profiles');
    }
};
