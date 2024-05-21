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
        Schema::table('users', function (Blueprint $table) {
            $table->string('bank_account_number_official')->nullable();
            $table->string('bank_account_number_personal')->nullable();
            $table->string('bkash_account_number')->nullable();
            $table->string('rocket_account_number')->nullable();
            $table->string('nogod_account_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('bank_account_number_official')->nullable();
            $table->string('bank_account_number_personal')->nullable();
            $table->string('bkash_account_number')->nullable();
            $table->string('rocket_account_number')->nullable();
            $table->string('nogod_account_number')->nullable();
        });
    }
};
