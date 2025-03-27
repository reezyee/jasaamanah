<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->date('order_date')->default(now()->toDateString()); // Perbaiki default value
            $table->string('status')->default('Pending');
            $table->string('progress_status')->default('Drafting');
            $table->text('admin_notes')->nullable();
            $table->json('attachment')->nullable();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->date('estimated_completion')->nullable();
            $table->enum('service_type', ['Website', 'Legality', 'Design']);
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('set null');
            $table->enum('division', ['legalitas', 'design', 'website']);
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
