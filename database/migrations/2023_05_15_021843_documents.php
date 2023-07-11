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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->integer('stt')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('category_id')->constrained('category_document');
            $table->string('department_send')->nullable();
            $table->string('document_number');
            $table->string('document_content');
            $table->date('document_time');
            $table->string('receiver');
            $table->string('signer')->nullable();
            $table->string('document_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
