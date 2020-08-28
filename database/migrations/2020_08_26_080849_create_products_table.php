<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('rubric_id');
            $table->integer('sub_rubric_id')->nullable();
            $table->integer('category_id');
            $table->string('manufacturer');
            $table->string('name');
            $table->unsignedBigInteger('code');
            $table->text('description')->nullable();
            $table->float('price')->default(0);
            $table->integer('guarantee');
            $table->boolean('availability');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
