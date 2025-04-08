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
    Schema::table('products', function (Blueprint $table) {
        $table->integer('stock')->default(0)->change(); // Ajout d'une valeur par défaut à 'stock'
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->integer('stock')->default(null)->change(); // Rétablir l'absence de valeur par défaut
    });
}

};
