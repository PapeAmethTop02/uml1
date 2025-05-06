<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['en attente', 'paye', 'livree'])->default('en attente');
            
            // Informations client
            $table->string('client_nom');
            $table->string('client_prenom');
            $table->string('client_email');
            $table->string('client_telephone');
            $table->string('client_adresse');
            $table->string('client_ville');
            $table->string('client_code_postal');
            
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
