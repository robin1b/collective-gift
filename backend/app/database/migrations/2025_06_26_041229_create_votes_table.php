<?php

// database/migrations/2025_06_26_000001_create_votes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')
                ->constrained()
                ->onDelete('cascade');
            // guest‐voting: user_id nullable
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('gift_idea_id')
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();

            // voorkom dubbele stemmen per (event, user, gift_idea)
            $table->unique(['event_id', 'user_id', 'gift_idea_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
