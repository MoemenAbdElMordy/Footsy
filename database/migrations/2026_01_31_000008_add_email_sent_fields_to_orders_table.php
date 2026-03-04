<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('order_email_sent_at')->nullable()->after('restocked_at');
            $table->timestamp('payment_email_sent_at')->nullable()->after('order_email_sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['order_email_sent_at', 'payment_email_sent_at']);
        });
    }
};
