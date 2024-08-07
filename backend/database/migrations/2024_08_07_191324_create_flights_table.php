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
        Schema::create('maintenance_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact');
            $table->string('specialization');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });

        Schema::create('aircraft', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('serial_number')->unique();
            $table->string('registration')->unique();
            $table->text('maintenance_history')->nullable();
            $table->unsignedBigInteger('maintenance_company_id')->nullable();
            $table->foreign('maintenance_company_id')->references('id')->on('maintenance_companies')->onDelete('cascade');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });

        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aircraft_id');
            $table->foreign('aircraft_id')->references('id')->on('aircraft')->onDelete('cascade');
            $table->text('issue_description');
            $table->enum('priority', ['Low', 'Medium', 'High']);
            $table->date('due_date');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
        Schema::dropIfExists('aircraft');
        Schema::dropIfExists('maintenance_companies');
    }
};
