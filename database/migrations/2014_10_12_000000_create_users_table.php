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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_role_id');
            $table->string('name');
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('image')->nullable();  
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('forgot_password_validate_string')->nullable();
            $table->string('verification_code')->nullable();
            $table->date('verification_code_sent_time')->nullable();
            $table->string('password'); 
            $table->integer('is_verified')->default('0');
            $table->unsignedBigInteger('is_active')->default('1');
            $table->unsignedBigInteger('is_approved')->default('0');
            $table->integer('is_deleted')->default('0');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
