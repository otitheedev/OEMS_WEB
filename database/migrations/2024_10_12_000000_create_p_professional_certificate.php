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
        Schema::create('child_professional_certificate', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_name')->nullable();
            $table->string('organization_name')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            # foreign ID
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
            // index on user_id column
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_professional_certificate');
    }
};
