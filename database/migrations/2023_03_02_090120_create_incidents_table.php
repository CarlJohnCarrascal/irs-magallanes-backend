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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id()->startingValue(100000);
            $table->bigInteger('userid');
            $table->bigInteger('manageby')->nullable();
            $table->string('report_type')->nullable();
            $table->bigInteger('informantid')->nullable();
            $table->bigInteger('patientid')->nullable();
            $table->string('type');
            $table->string('causes');
            $table->timestamp('datetime')->nullable();
            $table->string('barangay');
            $table->string('purok');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('specific_location')->nullable();
            $table->string('description')->nullable();
            $table->string('person_involves')->nullable();
            $table->boolean('is_police_needed')->default(false);
            $table->boolean('is_ambulance_needed')->default(false);
            $table->string('severity');
            $table->string('status');
            $table->timestamp('seened_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
