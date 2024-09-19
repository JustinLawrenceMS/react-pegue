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
        Schema::create('citations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->json('author')->nullable();
            $table->string('title')->nullable();
            $table->string('publication')->nullable();
            $table->json('year')->nullable();
            $table->integer('volume')->nullable();
            $table->integer('issue')->nullable();
            $table->string('pages')->nullable();
            $table->string('drug_type')->nullable();
            $table->json('mesh_headings')->nullable();
            $table->string('url')->nullable();
            $table->json('citation')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citations');
    }
};
