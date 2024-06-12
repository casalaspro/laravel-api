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
        Schema::table('works', function (Blueprint $table) {
            // aggiungo la colonna
            $table->unsignedBigInteger('type_id')->nullable()->after('id');
            // creo il vincolo
            $table->foreign('type_id')->references('id')->on('types')->onDelete('set null');

            // alternativa
            // $table->foreignId('type_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('works', function (Blueprint $table) {
            // rimuovo vincolo
            $table->dropForeign('works_type_id_foreign');
            // rimuovo colonna
            $table->dropColumn('type_id');
        });
    }
};
