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
        Schema::create('articles', function(Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string(('short_description'));
            $table->text('description');
            $table->bigInteger('price')->default(0);
            $table->string('price_by')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('address')->nullable();
            $table->string('link_google_maps')->nullable();
            $table->string('embed_gmaps_link')->nullable();
            $table->string('article_seo')->nullable();
            $table->string('thumbnail_name')->nullable();
            $table->string('thumbnail_path')->nullable();

            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('cascade');
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
