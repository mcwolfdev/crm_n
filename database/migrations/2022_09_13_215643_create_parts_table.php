<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('purchase_price')->default(0);
            $table->float('retail_price')->default(0);
            $table->integer('quantity')->default(0);
            $table->enum('unit', ['шт.', 'л.', 'мл.']);
            $table->integer('code')->nullable()->unique();
            $table->timestamps();
        });
        //
        Schema::create('job_part', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('job_id');
            $table->unsignedInteger('part_id');
            $table->float('sale_price');
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
        Schema::dropIfExists('parts');
        Schema::dropIfExists('job_part');
    }
};
