<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_transaction_custom_options', function (Blueprint $table) {
            $table->id();
            $table->integer('item_index');
            $table->foreignId('detail_transaction_id')->constrained();
            $table->foreignId('custom_option_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_custom_options');
    }
};
