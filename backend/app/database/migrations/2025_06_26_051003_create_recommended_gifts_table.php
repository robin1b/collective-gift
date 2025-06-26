<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommendedGiftsTable extends Migration
{
    public function up(): void
    {
        Schema::create('recommended_gifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gift_idea_id')
                ->constrained('gift_ideas')
                ->cascadeOnDelete();
            $table->string('affiliate_url');
            // optionele foto-URL:
            $table->string('image_url')->nullable();
            $table->timestamps();
            $table->unique('gift_idea_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommended_gifts');
    }
}
