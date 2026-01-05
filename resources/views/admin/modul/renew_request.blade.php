<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-semibold mb-1">Validasi Perpanjangan Pesanan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin', 'dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Validasi Perpanjangan Pesanan
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode Pesanan</th>
                        <th>Perusahaan</th>
                        <th>Nama Barang</th>
                        <th>Pallet</th>
                        <th>Perpanjangan</th>
                        <th>Tanggal Akhir Baru</th>
                        <th>Biaya Renew</th>
                        <th>Status Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td class="fw-medium">
                            {{ $order->order_code }}
                        </td>

                        <td>
                            {{ $order->user->company_name ?? '-' }}
                        </td>

                        <td>
                            {{ $order->item_name }}
                        </td>

                        <td>
                            {{ $order->pallet_estimated ?? 0 }}
                        </td>

                        {{-- TAMBAHAN DURASI --}}
                        <td>
                            {{ $order->renew_extend_days }} hari
                        </td>

                        {{-- TANGGAL AKHIR BARU --}}
                        <td>
                            {{ \Carbon\Carbon::parse($order->renew_end_date)
                                ->locale('id')
                                ->isoFormat('D MMM YYYY') }}
                        </td>

                        {{-- HARGA RENEW --}}
                        <td class="fw-semibold">
                            Rp {{ number_format($order->renew_price, 0, ',', '.') }}
                        </td>

                        {{-- STATUS BAYAR --}}
                        <td>
                            @php
                                $payColor = match($order->status_bayar) {
                                    'pending' => 'warning',
                                    'lunas'   => 'success',
                                    'gagal'   => 'danger',
                                    default   => 'secondary',
                                };
                            @endphp

                            <span class="badge bg-{{ $payColor }}">
                                {{ strtoupper($order->status_bayar) }}
                            </span>
                        </td>

                        {{-- AKSI --}}
                        <td>
                            <div class="btn-group btn-group-sm gap-1" role="group">

                                {{-- DETAIL / VALIDASI --}}
                                <a href="{{ route('admin.orders.renew.validation', $order->id) }}"
                                   class="btn btn-outline-primary d-flex align-items-center gap-1">
                                    <i class="fas fa-check-circle"></i>
                                    <span class="d-none d-md-inline">Validasi</span>
                                </a>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">
                            Belum ada pengajuan perpanjangan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
