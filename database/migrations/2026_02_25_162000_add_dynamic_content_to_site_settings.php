<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            // Contact extras
            $table->string('office_hours')->nullable();
            $table->string('whatsapp_url')->nullable();
            $table->string('linkedin_url')->nullable();

            // About / Overview
            $table->string('established_year')->nullable();
            $table->text('about_description')->nullable();
            $table->text('about_quote')->nullable();
            $table->string('about_image')->nullable();

            // Mission & Vision
            $table->string('mission_title')->nullable();
            $table->string('mission_subtitle')->nullable();
            $table->text('mission_description')->nullable();
            $table->string('vision_title')->nullable();
            $table->string('vision_subtitle')->nullable();
            $table->text('vision_description')->nullable();

            // Principal
            $table->string('principal_name')->nullable();
            $table->string('principal_title')->nullable();
            $table->string('principal_credentials')->nullable();
            $table->string('principal_experience')->nullable();
            $table->string('principal_image')->nullable();
            $table->json('principal_message')->nullable();

            // Home page sections (JSON arrays)
            $table->json('stats')->nullable();
            $table->json('carousel_slides')->nullable();
            $table->json('features')->nullable();
            $table->json('facilities')->nullable();

            // Welcome section
            $table->string('welcome_title')->nullable();
            $table->string('welcome_subtitle')->nullable();
            $table->text('welcome_description')->nullable();
            $table->string('welcome_image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'office_hours', 'whatsapp_url', 'linkedin_url',
                'established_year', 'about_description', 'about_quote', 'about_image',
                'mission_title', 'mission_subtitle', 'mission_description',
                'vision_title', 'vision_subtitle', 'vision_description',
                'principal_name', 'principal_title', 'principal_credentials',
                'principal_experience', 'principal_image', 'principal_message',
                'stats', 'carousel_slides', 'features', 'facilities',
                'welcome_title', 'welcome_subtitle', 'welcome_description', 'welcome_image',
            ]);
        });
    }
};
