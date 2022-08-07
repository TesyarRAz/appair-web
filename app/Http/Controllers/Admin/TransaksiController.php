<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\TransaksiDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Transaksi\StoreTransaksiRequest;
use App\Http\Requests\Admin\Transaksi\UpdateTransaksiRequest;
use App\Jobs\UploadFile;
use App\Models\Transaksi;
use App\Settings\PriceSetting;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TransaksiDataTable $dataTable)
    {
        $price = app(PriceSetting::class)->per_kubik;

        return $dataTable->render('admin.transaksi.index', compact('price'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransaksiRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('bukti_bayar'))
        {
            $data['bukti_bayar'] = UploadFile::dispatchSync($request->file('bukti_bayar'), 'images/bukti_bayar');
        }

        Transaksi::create($data);

        alert()->success('Transaksi berhasil ditambahkan.', 'Berhasil');

        return to_route('admin.transaksi.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi, Request $request)
    {
        $transaksi->load('customer.user');

        if ($request->type == 'invoice')
        {
            return view('admin.transaksi.invoice', compact('transaksi'));
        }
        
        return response($transaksi);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransaksiRequest $request, Transaksi $transaksi)
    {
        $data = $request->validated();

        if ($request->hasFile('bukti_bayar'))
        {
            $data['bukti_bayar'] = UploadFile::dispatchSync($request->file('bukti_bayar'), 'images/bukti_bayar');
        }

        $transaksi->update($data);

        alert()->success('Transaksi berhasil diubah.', 'Berhasil');

        return to_route('admin.transaksi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        alert()->success('Transaksi berhasil dihapus.', 'Berhasil');

        return to_route('admin.transaksi.index');
    }
}
