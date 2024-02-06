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
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('state_name');
            $table->unsignedBigInteger('country_id'); // Foreign key column
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();

              // Foreign key constraint
              $table->foreign('country_id')
              ->references('id')
              ->on('countries')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('states', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['country_id']);
        });

        Schema::dropIfExists('states');   
     }
};
