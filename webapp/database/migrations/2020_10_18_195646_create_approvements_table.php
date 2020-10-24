<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvements', function (Blueprint $table) {
            $table->id('product_id');
            $table->bigInteger('user_id');
            $table->boolean('isApproved')->default('False');
            $table->string('category', 25)->default('Inne');
            $table->string('name', 255);
            $table->string('image', 100);
            $table->string('barcode', 20)->nullable();
            $table->string('components', 1000)->nullable();
            $table->string('effects', 255)->nullable();
            $table->string('price', 10);
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
        Schema::dropIfExists('approvements');
    }
}
