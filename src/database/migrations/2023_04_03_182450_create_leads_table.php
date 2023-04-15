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
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description');
            $table->decimal('lead_value', 12)->nullable();
            $table->string('status');
            $table->string('lost_reason')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->unsignedBigInteger('lead_source_id');
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('lead_type_id');
            $table->unsignedBigInteger('pipeline_id');
            $table->unsignedBigInteger('pipeline_stage_id');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();

            $table->foreign('creator_id')
                ->references('id')
                ->on('persons')
                ->onDelete('no action');

            $table->foreign('manager_id')
                ->references('id')
                ->on('persons')
                ->onDelete('no action');

            $table->foreign('organization_id')
                ->references('id')
                ->on('organizations')
                ->onDelete('no action');

            $table->foreign('person_id')
                ->references('id')
                ->on('persons')
                ->onDelete('no action');

            $table->foreign('lead_source_id')
                ->references('id')
                ->on('lead_sources')
                ->onDelete('no action');

            $table->foreign('lead_type_id')
                ->references('id')
                ->on('lead_types')
                ->onDelete('no action');

            $table->foreign('pipeline_id')
                ->references('id')
                ->on('pipelines')
                ->onDelete('no action');

            $table->foreign('pipeline_stage_id')
                ->references('id')
                ->on('pipeline_stages')
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
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
