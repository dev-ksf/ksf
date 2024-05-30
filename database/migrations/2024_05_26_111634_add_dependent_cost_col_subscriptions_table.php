<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $table = 'subscriptions';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            if (!Schema::hasColumn($this->table, 'plan_cost')) {
                $table->double('plan_cost', 8, 2)->after('price')->nullable();
            }

            if (!Schema::hasColumn($this->table, 'dependent_cost')) {
                $table->double('dependent_cost', 8, 2)->after('plan_cost')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            if (Schema::hasColumn($this->table, 'plan_cost')) {
                $table->dropColumn('plan_cost');
            }
            if (Schema::hasColumn($this->table, 'dependent_cost')) {
                $table->dropColumn('dependent_cost');
            }
        });
    }
};
