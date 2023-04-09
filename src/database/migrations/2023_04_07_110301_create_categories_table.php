<?php

use App\Models\Category;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default(\App\Models\Category::TYPE_PUBLIC);
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            \Kalnoy\Nestedset\NestedSet::columns($table);
            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('no action');
        });

        Category::create([
            'name' => 'Главная',
            'type' => Category::TYPE_SYSTEM,
            'slug' => 'root',
            'children' => [
                [
                    'name' => 'Товары',
                    'type' => Category::TYPE_SYSTEM,
                    'slug' => 'products',
                ],
                [
                    'name' => 'Услуги',
                    'type' => Category::TYPE_SYSTEM,
                    'slug' => 'service',
                ],
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
