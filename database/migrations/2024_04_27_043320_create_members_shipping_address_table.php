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
        Schema::create('members_shipping_address', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->unsigned();
            $table->text('house_no');
            $table->text('unit_no');
            $table->string('city');
            $table->string('country');
            $table->string('zip_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members_shipping_address');
    }
};
