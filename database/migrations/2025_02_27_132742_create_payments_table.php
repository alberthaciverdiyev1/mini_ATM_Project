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
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('account_id')->constrained('accounts')->cascadeOnDelete();
                $table->decimal('amount', 15, 4);
                $table->tinyInteger('type')->comment('1: IN, 2: OUT');
                $table->tinyInteger('source')->default(1)->comment('1: ATM, 2: User');
                $table->tinyInteger('status')->default(1)->comment('1: Active, 2: Cancelled');
                $table->timestamps();
                $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
