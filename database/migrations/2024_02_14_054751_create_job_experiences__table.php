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
        Schema::create('child_jobexprieces', function (Blueprint $table) {
            $table->id();

            $table->string('job_designation_name')->nullable();
            $table->string('job_org_name')->nullable();
            $table->date('job_start_date')->nullable();
            $table->date('job_end_date')->nullable();

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
        Schema::dropIfExists('child_jobExprieces');
    }
};
