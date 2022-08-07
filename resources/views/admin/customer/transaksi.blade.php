@extends('layouts.admin')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <div class="row no-gutters">
                <div class="col d-flex">
                    <a href="{{ route('admin.customer.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-fw fa-arrow-left"></i>
                    </a>
                    <h6 class="text-primary font-weight-bold ml-2 my-auto">Transaksi - {{ $customer->user->name }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Total Harga</th>
                            <th>Meteran Akhir</th>
                            <th>Total Penggunaan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge badge-danger">
                                    {{ optional($item->tanggal_bayar)->isoFormat('MMMM Y') ?? '-' }}
                                </span>
                            </td>
                            <td>{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            <td>{{ $item->meteran_akhir }}</td>
                            <td>{{ $item->meteran_akhir - $item->meteran_awal }} Kubik</td>
                            <td>
                                @if ($item->status == 'diterima')
                                    <span class="badge badge-success">Diterima</span>
                                @elseif ($item->status == 'ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                @elseif ($item->status == 'lewati')
                                    <span class="badge badge-warning">Dilewati</span>
                                @elseif ($item->status == 'lunas')
                                    <span class="badge badge-primary">Lunas</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="text-center">Tidak Ada Data</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
