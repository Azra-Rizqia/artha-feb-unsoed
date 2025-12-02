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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();     // contoh: ORD-20250101-001
            $table->string('nama_pemesan');              // nama pembeli / pemesan);
            $table->timestamp('order_date')->useCurrent();
            $table->enum('payment_method', ['tunai', 'qris']);   // tunai / qris
            $table->unsignedInteger('total_uang_masuk');            // total uang masuk
            $table->unsignedInteger('total_modal');              // total modal terpakai
            $table->unsignedInteger('total_profit');            // total keuntungan

            $table->enum('status', ['selesai', 'batal'])->default('selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_tabel');
    }
};
