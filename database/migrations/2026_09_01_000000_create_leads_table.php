<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('service')->nullable();
            $table->string('property_type')->nullable();
            $table->text('message')->nullable();
            $table->string('city')->nullable();
            // D'où vient le lead : formulaire complet ou rappel express, et sur quelle page.
            $table->string('kind')->default('quote');
            $table->string('source_page')->nullable();
            $table->string('ip', 45)->nullable();
            $table->boolean('mail_sent')->default(false);
            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
