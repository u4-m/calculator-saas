<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('material_id')->nullable()->constrained()->onDelete('set null');
            $table->string('material_name');
            $table->decimal('weight', 10, 2);
            $table->integer('print_time');
            $table->decimal('electricity_cost', 10, 4);
            $table->decimal('labor_cost', 10, 2);
            $table->decimal('profit_margin', 5, 2);
            $table->decimal('material_cost', 10, 2);
            $table->decimal('total_electricity_cost', 10, 2);
            $table->decimal('total_labor_cost', 10, 2);
            $table->decimal('total_cost', 10, 2);
            $table->decimal('final_price', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculations');
    }
};
