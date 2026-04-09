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
        Schema::create('donation_request_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('donation_request_id');
            $table->date('date');
            $table->text('notes')->nullable();
            $table->string('status');
            $table->timestamps();

            // Foreign Keys
            $table->foreign('donation_request_id')
                ->references('id')
                ->on('donation_requests')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_request_schedules');
    }
};
