<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Nama pekerjaan dari order
            $table->text('description')->nullable(); // Detail pekerjaan
            $table->enum('division', ['legalitas', 'design', 'website']); // Divisi pekerjaan
            $table->string('status'); // Status pekerjaan (mirrors progress_status)
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null'); // Pekerja
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Foreign key to orders
            $table->json('file_attachment')->nullable(); // Multiple attachments as JSON array
            $table->text('note')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};