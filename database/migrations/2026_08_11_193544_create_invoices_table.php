<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->string('invoice_number')->unique(); // Numéro officiel Elva
            $table->enum('type', ['facture', 'avoir'])->default('facture'); // Facture ou Avoir
            $table->decimal('amount_ttc', 10, 2);
            $table->string('pdf_path')->nullable(); // Chemin du fichier PDF stocké
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
