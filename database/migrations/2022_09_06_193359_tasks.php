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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('price')->default(0);
            $table->integer('performer_percent')->default(50);
            $table->integer('hourly_rate')->comment('Бабок за час');
            $table->integer('code')->comment('Код задачи')->nullable();
            $table->timestamps();
        });
        // Эта табличка связей много ко многому - все то же самое что и было только работает из коробки
        Schema::create('job_task', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('task_id');
            $table->float('price')->default(0);
            $table->integer('performer_percent')->nullable();
            $table->integer('hourly_rate')->nullable();
            $table->integer('code')->comment('Код задачи')->nullable();
            $table->timestamps();
            $table->foreign('job_id')->references('id')->on('jobs')
                ->onUpdate('cascade'); //->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')
                ->onUpdate('cascade');//->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_task');
        Schema::dropIfExists('tasks');
    }
};
