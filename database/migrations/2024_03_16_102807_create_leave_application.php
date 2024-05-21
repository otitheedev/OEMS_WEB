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
        Schema::create('leave_application', function (Blueprint $table) {
            $table->id();
            # foreign ID
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('application_type')->nullable();
            $table->longtext('application_message')->nullable();
            $table->date('application_start_date')->nullable();
            $table->date('application_end_date')->nullable();
            $table->text('file_applications')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('view')->default(false);
            $table->unsignedBigInteger('approved_user_id')->nullable();

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
        Schema::dropIfExists('leave_application');
        
    }
};
