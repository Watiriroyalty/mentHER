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
        Schema::create('mentorship_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mentee_id');
            $table->unsignedBigInteger('mentor_id');
            $table->text('message');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('mentee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mentor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentorship_requests');
    }
};
