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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id'); // Foreign key column
            $table->unsignedBigInteger('state_id'); // Foreign key column
            $table->string('city_name');
            $table->boolean('is_active');
           
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('country_id')
            ->references('id')
            ->on('countries')
            ->onDelete('cascade');
            $table->foreign('state_id')
            ->references('id')
            ->on('states')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['country_id']);
            $table->dropForeign(['state_id']);
        });
        Schema::dropIfExists('cities');
    }
};
