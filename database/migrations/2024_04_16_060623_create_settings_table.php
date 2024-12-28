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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // General Settings
            $table->string('site_name', 250)->nullable();
            $table->text('site_motto')->nullable();
            $table->text('site_url')->nullable();
            $table->text('address_line_one')->nullable();
            $table->text('address_line_two')->nullable();
            $table->string('default_language', 50)->nullable();
            $table->string('default_currency', 100)->nullable();
            $table->string('currency_symbol', 10)->nullable();
            $table->string('date_format', 50)->default('Y-m-d');
            $table->string('time_format', 50)->default('H:i');

            // Social Media
            $table->text('facebook_url')->nullable();
            $table->text('twitter_url')->nullable();
            $table->text('instagram_url')->nullable();
            $table->text('linkedin_url')->nullable();
            $table->text('youtube_url')->nullable();
            $table->text('github_url')->nullable();
            $table->text('portfolio_url')->nullable();
            $table->text('fiverr_url')->nullable();
            $table->text('upwork_url')->nullable();

            // Logo & Favicon
            $table->string('site_white_logo', 255)->nullable();
            $table->string('site_black_logo', 255)->nullable();
            $table->string('site_favicon', 255)->nullable();

            // Contact Information
            $table->string('contact_email', 100)->nullable();
            $table->string('support_email', 100)->nullable();
            $table->string('info_email', 100)->nullable();
            $table->string('sales_email', 100)->nullable();
            $table->string('phone_one', 20)->nullable();
            $table->string('phone_two', 20)->nullable();
            $table->string('whatsapp_number', 20)->nullable();
            $table->string('contact_hours', 255)->nullable(); // e.g., "Mon-Fri, 9 AM - 5 PM"

            // Maintenance Mode
            $table->boolean('maintenance_mode')->default(false);
            $table->string('system_timezone', 200)->nullable(); // e.g., UTC, EST
            $table->text('maintenance_message')->nullable();
            $table->longText('additional_script')->nullable();
            $table->text('google_adsense')->nullable();
            $table->text('google_tag_manager')->nullable();
            $table->text('google_script')->nullable();
            $table->text('google_business')->nullable();

            // SEO Settings
            $table->string('seo_title', 255)->nullable();
            $table->string('seo_keywords', 255)->nullable();
            $table->text('seo_meta_tags')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('og_image', 255)->nullable();
            $table->string('og_title', 255)->nullable();
            $table->text('og_description')->nullable();
            $table->text('canonical_url')->nullable();



            // Advanced Settings
            $table->string('theme_color', 50)->nullable();
            $table->boolean('dark_mode')->default(false);
            $table->longText('custom_css')->nullable();
            $table->longText('custom_js')->nullable();

            // API Integration
            $table->text('map_api_key')->nullable();
            $table->text('payment_gateway_key')->nullable();

            // Business Information
            $table->string('company_name')->nullable();
            $table->string('tax_number', 100)->nullable();
            $table->text('billing_address')->nullable();

            // Service Info
            $table->string('service_days')->nullable();
            $table->string('service_time')->nullable();

            // Meta Fields
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};


//$table->string('currency', 10)->default('USD');
//$table->string('timezone', 50)->default('UTC');
//$table->integer('pagination_count')->default(15);
//$table->string('analytics_code', 255)->nullable();
//$table->string('google_maps_key', 255)->nullable();
//$table->string('recaptcha_site_key', 255)->nullable();
//$table->string('recaptcha_secret_key', 255)->nullable();
