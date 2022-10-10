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
        Schema::create('provisioners', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('code');
            $table->string('name');
            // Переименовать или поменять поле
            $table->text('provisioner_property')->nullable();

            $table->text('contacts')->nullable();
            $table->text('contract')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        /*Schema::create('part_provisioners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('part_id');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('part_id')->references('id')->on('parts')
                ->onUpdate('cascade'); //->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')
                ->onUpdate('cascade');//->onDelete('cascade');
            $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provisioners');
    }
};
