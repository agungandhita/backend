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
        Schema::table('tools', function (Blueprint $table) {
            $table->string('kategori')->nullable()->after('file_pdf');
            $table->integer('views_count')->default(0)->after('kategori');
            $table->boolean('is_featured')->default(false)->after('views_count');
            $table->boolean('is_active')->default(true)->after('is_featured');
            $table->json('tags')->nullable()->after('is_active');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null')->after('tags');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['kategori', 'views_count', 'is_featured', 'is_active', 'tags', 'category_id']);
        });
    }
};