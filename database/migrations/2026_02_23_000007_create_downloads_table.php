<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained('download_categories')->restrictOnDelete();
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->enum('type', ['file', 'link'])->default('file');
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'published_at']);
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('downloads');
    }
};
