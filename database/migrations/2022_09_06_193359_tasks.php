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
            $table->unsignedInteger('job_id');
            $table->unsignedInteger('task_id');
            $table->float('price')->default(0);
            $table->integer('performer_percent')->nullable();
            $table->integer('hourly_rate')->nullable();
            $table->integer('code')->comment('Код задачи')->nullable();
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
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('job_task');
    }
};
