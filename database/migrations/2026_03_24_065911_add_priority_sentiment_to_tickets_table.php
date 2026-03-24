<?php

use App\Enums\Priority;
use App\Enums\TicketSentiment;
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
        Schema::table('tickets', function (Blueprint $table) {
            $table->enum('priority', array_column(Priority::cases(), 'value'))->nullable()->after('state');
            $table->enum('sentiment', array_column(TicketSentiment::cases(), 'value'))->nullable()->after('priority');
            $table->string('department')->nullable()->after('sentiment');
            $table->json('ai_tags')->nullable()->after('department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['priority', 'sentiment', 'department', 'ai_tags']);
        });
    }
};
