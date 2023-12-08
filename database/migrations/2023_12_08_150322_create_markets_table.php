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
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('description')->nullable();
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(1);
            $table->foreignId('parent_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->boolean('is_active')->default(1);
            $table->string('slug')->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('attribute_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean('is_filter')->default(0);
            $table->boolean('is_variation')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['category_id','attribute_id']);
        });
        

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('short_description');
            $table->text('long_description')->nullable();
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('brand_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('primary_image');
            $table->boolean('marketable')->default(1);
            $table->boolean('is_active')->default(1);
            $table->timestamp('published_at')->default(now());
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('attribute_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('value')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string("sku")->unique();
            $table->bigInteger('original_price');
            $table->bigInteger('sale_count')->default(0);
            $table->bigInteger('reservation_count')->default(0);
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
            $table->boolean('is_active')->default(1);
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


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variations');
        Schema::dropIfExists('attribute_product');
        Schema::dropIfExists('products');
        Schema::dropIfExists('attribute_category');
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('brands');

    }
};
