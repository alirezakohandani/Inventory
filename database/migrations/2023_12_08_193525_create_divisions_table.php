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
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable()->index();
            $table->string("type")->index();

            $table->string('title_en')->nullable()->index();
            $table->string('title_fa')->nullable()->index();

            $table->unsignedInteger('province_id')->default(0)->index();
            $table->unsignedInteger('city_id')->default(0)->index();
            $table->unsignedInteger('capital_id')->default(0)->index();

            $table->float('latitude')->nullable()->index();
            $table->float('longitude')->nullable()->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};
