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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->string('kategori'); // makanan, minuman, snack, dll
            
            $table->string('image_url')->nullable();
            $table->integer('stock')->default(0);

            $table->unsignedInteger('harga_modal');       // harga modal
            $table->unsignedInteger('persen_keuntungan');   // persen keuntungan
            $table->unsignedInteger('harga_jual');    // harga jual (final)

            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_tabel');
    }
};
