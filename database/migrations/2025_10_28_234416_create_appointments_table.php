<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\AppointmentStatus;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('repair_type_id')->nullable()->constrained('repair_types')->nullOnDelete();
            $table->dateTime('appointment_date');
            $table->text('issue_description')->nullable();
            $table->string('status')->default(AppointmentStatus::Pending->value);
            $table->string('sub_status')->nullable();
            $table->integer('estimated_repair_duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
