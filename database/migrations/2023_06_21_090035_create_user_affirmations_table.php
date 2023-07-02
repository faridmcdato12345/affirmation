<?php

use App\Models\User;
use App\Models\UserCategories;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_affirmations', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->foreignIdFor(UserCategories::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_affirmations');
    }
};
