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
            if (!Schema::hasColumn($this->table, 'description')) {
                $table->text('description')->after('plan_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            if (Schema::hasColumn($this->table, 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
