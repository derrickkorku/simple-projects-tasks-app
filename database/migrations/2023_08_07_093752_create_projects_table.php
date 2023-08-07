<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('projects')->delete();

        DB::table('projects')->insert([
            ['id' => 1, 'name' => 'Project 1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Project 2', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Project 3', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
