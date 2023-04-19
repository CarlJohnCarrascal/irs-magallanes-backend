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
        Schema::create('responders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('incidentid');
            $table->string('leader')->nullable();
            $table->string('driver')->nullable();
            $table->string('member1')->nullable();
            $table->string('member2')->nullable();
            $table->string('member3')->nullable();
            $table->string('member4')->nullable();
            $table->string('member5')->nullable();
            $table->string('member6')->nullable();
            $table->string('member7')->nullable();
            $table->string('member8')->nullable();
            $table->string('member9')->nullable();
            $table->string('member10')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responders');
    }
};
