<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *    'uid' => $uid,
           
     */
    public function up(): void
    {
        Schema::create('attendance_users', function (Blueprint $table) {
            $table->id();
            $table->integer('uid')->nullable();
            $table->integer('userid')->nullable();
            $table->string('name')->nullable();
            $table->string('role')->nullable();
            $table->string('password')->nullable();
            $table->string('cardno')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_users');
    }
};
