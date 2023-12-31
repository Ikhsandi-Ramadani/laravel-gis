<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->longText('deskripsi');
            $table->foreignId('kecamatan_id')->references('id')->on('kecamatans')->cascadeOnDelete();
            $table->string('kelurahan');
            $table->string('desa');
            $table->foreignId('pengawas_id')->references('id')->on('users')->cascadeOnDelete();
            $table->integer('anggaran');
            $table->string('tender');
            $table->date('t_awal');
            $table->date('t_akhir');
            $table->boolean('status')->default(0);
            $table->string('latitude');
            $table->string('longitude');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
