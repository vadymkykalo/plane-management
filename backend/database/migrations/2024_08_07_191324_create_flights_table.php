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
        Schema::create('aircrafts', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('serial_number')->unique();
            $table->string('registration')->unique();
            $table->timestamps();
            $table->boolean('is_deleted')->default(false);
        });

        Schema::create('maintenance_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact');
            $table->string('specialization');
            $table->timestamps();
            $table->boolean('is_deleted')->default(false);
        });

        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aircraft_id')->constrained('aircrafts');
            $table->foreignId('maintenance_company_id')->nullable()->constrained('maintenance_companies');
            $table->text('issue_description');
            $table->enum('priority', ['Low', 'Medium', 'High']);
            $table->date('due_date');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->timestamps();
        });

        Schema::create('aircraft_maintenance_company', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_requests_id')->constrained('service_requests');
            $table->foreignId('aircraft_id')->constrained('aircrafts');
            $table->foreignId('maintenance_company_id')->constrained('maintenance_companies');
            $table->timestamps();
            $table->boolean('is_deleted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aircraft_maintenance_company');
        Schema::dropIfExists('service_requests');
        Schema::dropIfExists('maintenance_companies');
        Schema::dropIfExists('aircrafts');
    }
};
