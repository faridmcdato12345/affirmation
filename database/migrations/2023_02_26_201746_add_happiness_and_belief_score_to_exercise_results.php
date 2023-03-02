<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exercise_results', function (Blueprint $table) {
            $table->tinyInteger('happiness_score');
            $table->tinyInteger('belief_score');
            $table->dropColumn('believe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exercise_results', function (Blueprint $table) {
            $table->dropColumn('happiness_score');
            $table->dropColumn('belief_score');
        });
    }
};
