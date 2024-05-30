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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('plan_id');
            $table->integer('member_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('status')->comment('active, inactive, suspended, cancelled');
            $table->integer('billing_cycle');
            $table->boolean('auto_renewal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
