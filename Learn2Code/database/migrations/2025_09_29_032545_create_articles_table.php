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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('excerpt')->nullable(); // บทนำสั้นๆ
            $table->longText('content');
            $table->string('featured_image', 500)->nullable();
            $table->string('author', 100)->default('Learn2Code Team');
            $table->json('tags')->nullable(); // เก็บ tags เป็น JSON array
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('views')->default(0);
            $table->boolean('featured')->default(false); // บทความเด่น
            $table->string('slug', 255)->unique(); // สำหรับ SEO-friendly URL
            $table->text('meta_description')->nullable(); // สำหรับ SEO
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['status', 'published_at']);
            $table->index(['featured', 'published_at']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
