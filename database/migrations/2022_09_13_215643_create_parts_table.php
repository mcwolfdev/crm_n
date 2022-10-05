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
        //Запчастини довідник
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->string('name');
            $table->float('purchase_price')->default(0);
            $table->float('retail_price')->default(0);
            $table->integer('quantity')->default(0);
            $table->enum('unit', ['шт.', 'л.', 'мл.']);
            $table->integer('code')->nullable()->unique();
            $table->timestamps();
        });

        //товари з роботами
        Schema::create('job_part', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('job_id');
            $table->unsignedInteger('part_id');
            $table->unsignedInteger('quantity')->default(0);
            $table->float('sale_price');
            $table->timestamps();
        });
        //прихід товарів (sync)
        Schema::create('parts_arrival', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('parts_id');
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('quantity');
            $table->float('purchase_price')->default(0);
            $table->float('retail_price')->default(0);
            $table->timestamps();
        });
        //історія приходу товарів (attach)
        Schema::create('parts_arrival_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('provisioner_id');
            $table->unsignedInteger('parts_id');
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('quantity');
            $table->float('purchase_price')->default(0);
            $table->float('retail_price')->default(0);
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
        Schema::dropIfExists('parts_arrival');
        Schema::dropIfExists('parts_arrival_history');

    }
};
