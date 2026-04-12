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
        Schema::create('quantities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospital_id');
            $table->unsignedBigInteger('donation_request_id')->nullable();
            $table->unsignedBigInteger('blood_request_id')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedInteger('previous_quantity')->default(0);
            $table->unsignedInteger('current_quantity')->default(0);
            $table->string('type'); // system or external
            $table->string('blood_type');
            $table->string('status');
            $table->timestamps();

            // foreign keys
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
            $table->foreign('donation_request_id')->references('id')->on('donation_requests')->onDelete('cascade');
            $table->foreign('blood_request_id')->references('id')->on('blood_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quantities');
    }
};
