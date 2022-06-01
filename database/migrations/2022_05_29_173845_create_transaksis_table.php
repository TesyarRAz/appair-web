<?php

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->foreignIdFor(Customer::class)->constrained();
            $table->foreignIdFor(User::class, 'admin_id')->nullable()->constrained('users');

            $table->string('bukti_bayar')->nullable();
            $table->enum('status', ['diterima', 'lewati', 'ditolak', 'lunas'])->default('diterima');
            $table->string('keterangan_ditolak')->nullable();
            
            $table->unsignedInteger('total_bayar')->default(0);
            $table->unsignedInteger('total_harga')->default(0);
            $table->date('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
};
