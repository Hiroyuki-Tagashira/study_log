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
        Schema::table('codes', function (Blueprint $table) {

            $table->dropForeign(['studylog_id']);
            $table->dropColumn('studylog_id');
            $table->foreignId('study_log_id')->constrained('study_logs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('codes', function (Blueprint $table) {
            $table->foreignId('studylog_id')->constrained();
            $table->dropColumn('study_log_id');
        });
    }
};
