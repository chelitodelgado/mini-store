<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatabaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Table Products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('cost',8,2);
            $table->integer('stock');
            $table->timestamps();
        });

        // Table Providers
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact');
            $table->integer('tel');
            $table->timestamps();
        });

        // Table Categorys
        Schema::create('categorys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Table Sales
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->boolean('state');
            $table->integer('quanity');
            $table->decimal('total',8,2);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    /* public function down()
    {
        Schema::dropIfExists('database');
    } */
}
