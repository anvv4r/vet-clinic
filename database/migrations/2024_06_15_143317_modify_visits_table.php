<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->renameColumn('description', 'report');
            $table->unsignedBigInteger('owner_id')->after('pet_id');
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->renameColumn('report', 'description');
            $table->dropForeign(['owner_id']); // Drop foreign key constraint
            $table->dropColumn('owner_id'); // Drop the owner_id column
        });
    }
};
