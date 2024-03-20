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
        Schema::create('holiday_event', function (Blueprint $table) {
            $table->id();
            $table->text('holiday_type')->nullable();
            $table->text('holiday_title')->nullable();
            $table->longtext('holiday_message')->nullable();
            $table->string('holiday_file')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('view')->default(false);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        
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
