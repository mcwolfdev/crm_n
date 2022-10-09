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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('vehicle_id');
            $table->unsignedInteger('creator_id');
            $table->unsignedInteger('performer_id');
            $table->string('status');
            $table->string('addition')->default(null);
            $table->string('pay');
            $table->float('pay_summ')->default(0);
            $table->string('done_at');

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
        Schema::dropIfExists('jobs');
    }
};
