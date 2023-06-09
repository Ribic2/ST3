<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('friend_list', function (Blueprint $table) {
            $table->id();
            $table->boolean('accepted')->default(null)->nullable();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('friend_id')->references('id')->on('users');
            $table->foreignId('requested_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
