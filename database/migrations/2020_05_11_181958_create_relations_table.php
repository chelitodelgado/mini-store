<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Relationship whit the table Providers and product
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categorys')->onDelete('cascade');
        });

        // Relationship whit the table Products
        Schema::table('sales', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relations');
    }
}
