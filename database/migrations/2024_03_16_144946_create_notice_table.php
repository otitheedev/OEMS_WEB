<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.ss
     */
    public function up(): void
    {
        Schema::create('notice', function (Blueprint $table) {
            $table->id();
            $table->text('notice_type')->nullable();
            $table->text('notice_title')->nullable();
            $table->longtext('notice_message')->nullable();
            $table->string('notice_file')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('view')->default(false);
            $table->timestamps();
 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notice');
    }
};
