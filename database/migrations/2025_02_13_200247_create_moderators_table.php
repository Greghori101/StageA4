<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('moderators', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->text('biography')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('moderators');
    }
};
