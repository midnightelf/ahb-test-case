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
        Schema::create('record_additionals', function (Blueprint $table) {
            $table->id();
            $table->mediumInteger('count');
            $table->text('properties')->nullable();
            $table->boolean('can_joint_purchases')->default(false);
            $table->string('unit', 16);
            $table->string('image')->nullable();
            $table->boolean('can_display_on_main')->default(false);
            $table->text('description')->nullable();
            $table->foreignId('record_id')
                ->unique()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('record_additionals');
    }
};
