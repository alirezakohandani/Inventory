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
            $table->string("username")->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string("avatar")->nullable();
            $table->string("gender")->nullable();
            $table->timestamp("birth_at")->nullable();

            $table->boolean("is_admin")->default(0);
            $table->boolean("is_active")->default(1);

            $table->string('email')->nullable()->unique();
            $table->timestamp('email_confirmed_at')->nullable();
            
            $table->string("mobile")->unique();
            $table->timestamp("mobile_confirmed_at")->nullable();

            $table->string("code_melli")->nullable();
            $table->timestamp("code_melli_confirmed_at")->nullable();

            $table->string('password')->nullable();
            $table->boolean("password_force_change")->default(0);
            $table->timestamp("password_expires_at")->nullable();
            
            $table->rememberToken();
            $table->timestamps();
        });


        Schema::create('otps', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string("code");
            $table->timestamp("expires_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
        Schema::dropIfExists('users');

    }
};
