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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->unique()->index();
            $table->string('name_fa')->unique()->index();
            $table->string('description')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('logo')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:active 2:inactive');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique()->index();
            $table->string('description')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:active 2:inactive');
            $table->tinyInteger('show_in_menu')->default(1)->comment('1:show 2:hidden');
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique()->index();
            $table->tinyInteger('status')->default(1)->comment('1:active 2:inactive');
            $table->string('slug')->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('attribute_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained('attributes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('is_filter', [1,2])->default(1)->comment('1: deactive, 2:active');
            $table->enum('is_variation', [1,2])->default(1)->comment('1: is not variation, 2: is variation');
            $table->timestamps();
            $table->softDeletes();
        });
        

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique()->index();
            $table->string('short_description');
            $table->text('long_description')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('sku')->unique();
            $table->string("variable")->nullable()->comment("for example: size, model, color & ...");
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->string('image');
            $table->tinyInteger('marketable')->default(1);
            $table->tinyInteger('status')->default(1)->comment('1:active 2:inactive');
            $table->timestamp('published_at')->default(now());
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('attribute_product', function (Blueprint $table) {
            $table->id();
            $table->string('value')->nullable();
            $table->foreignId('attribute_id')->constrained('attributes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->tinyInteger(' status')->default(1)->comment('1:active 2:inactive');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_variation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained('attributes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('original_price');
            $table->bigInteger('sale_count')->default(0);
            $table->bigInteger('reservation_count')->default(0);
            $table->string("sku")->unique();
            $table->bigInteger('buy_price');
            $table->boolean("has_discount")->default(0);
            $table->boolean("has_limited")->default(0);
            $table->integer("limited_amount")->nullable();
            $table->bigInteger("discount_price")->default(0);
            $table->dateTime("discount_price_started_at");
            $table->dateTime("discount_price_expires_at");
            $table->integer("tax_percent")->default(0)->comment("0% to 100%");
            $table->bigInteger('marketable_number')->default(0);
            $table->tinyInteger('marketable')->default(1);
            $table->tinyInteger('status')->default(1)->comment('1:active 2:inactive');
            $table->boolean('downloadable')->default(0)->comment('1: downloadable 0: no downloadable');
            $table->string("url")->nullable()->comment('download link for downloadable ware');
            $table->double("height")->default(0);
            $table->double("width")->default(0);
            $table->double("length")->default(0);
            $table->double("mass")->default(0);
            $table->tinyInteger("breakable")->default(0)->nullable()->comment('1: breakable 2: no breakable');
            $table->timestamp('published_at')->default(now());
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('attribute_product', function (Blueprint $table) {
            $table->id();
            $table->string('value')->nullable();
            $table->foreignId('attribute_id')->constrained('attributes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('markets');
    }
};
