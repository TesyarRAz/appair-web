@extends('layouts.admin')

@section('content')
<div id="invoice-print">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">
                    <div class="row no-gutters">
                        <div class="col">
                            <h6 class="text-primary font-weight-bold">Invoice Transaksi</h6>
                        </div>
                        <div class="ml-auto">
                            <button class="btn d-print-none btn-primary btn-sm" onclick="printInvoice()">
                                <i class="fas fa-fw fa-print"></i>
                                Print
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="font-weight-bold">{{ $transaksi->kode }}</h5>
                    <div class="row justify-content-between">
                        <div class="col">
                            <span class="text-muted">
                                Pelanggan : {{ $transaksi->customer->user->name }}
                            </span>
                        </div>
                        <div class="col justify-content-end d-flex">
                            <span class="text-muted">
                                Tanggal Bayar : {{ $transaksi->tanggal_bayar->isoFormat('MMMM Y') }}
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="text-muted mt-4 mb-1">
                        <p>Terimakasih Anda telah melakukan pembayaran sebesar <span class="font-weight-bold">Rp. {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span> 
                        pada bulan <span class="badge badge-danger">{{ $transaksi->tanggal_tempo->isoFormat('MMMM Y') }}</span> 
                        dengan total pemakaian <span class="font-weight-bold">{{ $transaksi->meteran_akhir - $transaksi->meteran_awal }} Meter Kubik</span>. 
                        Meteran akhir Anda adalah {{ $transaksi->meteran_akhir }}
                        </p>
                    </div>
                    <div class="pt-5">
                        <span class="mx-1">{{ auth()->user()->name }}</span>
                        <div class="py-2"></div>
                        <div class="pt-5">
                        ................................
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">
function printInvoice() {
    let oldElement = $("body").html();
    let newElement = $("#invoice-print").html();
    newElement = `<div class="vh-100">${newElement}</div>`;
    $("body").html(newElement);
    window.print();
    $("body").html(oldElement);
}
</script>
@endpush