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
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospital_id');
            $table->string('blood_type');
            $table->string('quantity');
            $table->string('urgency_lvl');
            $table->dateTime('request_date');
            $table->unsignedBigInteger('confirmed_by')->nullable();
            $table->string('status');
            $table->timestamps();

            // Foreign Keys
            $table->foreign('hospital_id')
                ->references('id')
                ->on('hospitals')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('confirmed_by')
                ->references('id')
                ->on('hospitals')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
};
