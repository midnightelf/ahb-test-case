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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            /**
             * не стал делать уникальным чтобы оставить возможность 
             * загружать этот же файл еще и еще. ну чтобы можно было потыкать
             */
            // $table->string('code')->unique();
            $table->string('code');
            $table->string('name');
            $table->float('price');
            $table->float('price_sp');
            $table->string('level1')->nullable();
            $table->string('level2')->nullable();
            $table->string('level3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
