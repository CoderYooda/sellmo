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
        Schema::create('pipeline_stages', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->integer('order');
            $table->unsignedBigInteger('pipeline_id');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();

            $table->foreign('pipeline_id')
                ->references('id')
                ->on('pipelines')
                ->onDelete('no action');

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pipeline_stages');
    }
};
