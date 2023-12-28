<?php

use App\Models\AppVersion;
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
        Schema::create('app_version_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('app_version_id');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('app_version_id')->references('id')->on('app_versions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_version_lists');
    }
};
