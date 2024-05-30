<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $table = 'plans';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            if (!Schema::hasColumn($this->table, 'semi_annual_dependent_price')) {
                $table->double('semi_annual_dependent_price', 8, 2)->after('annual_price')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'annual_dependent_price')) {
                $table->double('annual_dependent_price', 8, 2)->after('semi_annual_dependent_price')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            if (Schema::hasColumn($this->table, 'semi_annual_dependent_price')) {
                $table->dropColumn('semi_annual_dependent_price');
            }
            if (Schema::hasColumn($this->table, 'annual_dependent_price')) {
                $table->dropColumn('annual_dependent_price');
            }
        });
    }
};
