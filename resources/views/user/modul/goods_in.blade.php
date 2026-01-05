@php
    use Carbon\Carbon;
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-semibold mb-1">Barang Masuk</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item">
                    <a href="{{ route('user', 'dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Barang Masuk
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
                        <th>Nama Barang</th>
                        <th>Tipe Barang</th>
                        <th>Jumlah</th>
                        <th>Estimasi Tiba</th>
                        <th>Tanggal Tiba</th>
                        <th>Tujuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($orders ?? [] as $order)

                @php
                    $estimated = $order->estimated_delivery
                        ? Carbon::parse($order->estimated_delivery)->startOfDay()
                        : null;

                    $diffDays = $estimated
                        ? now()->startOfDay()->diffInDays($estimated, false)
                        : null;
                @endphp

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-medium">{{ $order->order_code }}</td>
                    <td>{{ $order->item_name }}</td>
                    <td>{{ $order->item_type ?? '-' }}</td>
                    <td>{{ number_format($order->quantity) }}</td>

                    {{-- Estimasi Tiba --}}
                    <td class="fw-medium">
                        @if($diffDays !== null)
                            @if($diffDays > 0)
                                {{ $diffDays }} hari lagi
                            @elseif($diffDays == 0)
                                Hari ini
                            @else
                                <span class="text-danger">
                                    Terlambat {{ abs($diffDays) }} hari
                                </span>
                            @endif
                        @else
                            -
                        @endif
                    </td>

                    {{-- Tanggal Tiba --}}
                    <td>
                        {{ $estimated ? $estimated->translatedFormat('d M Y') : '-' }}
                    </td>

                    {{-- Tujuan --}}
                    <td>Gudang Utama</td>

                    {{-- Status --}}
                    <td>
                        <span class="badge bg-{{ $order->status === 'upcoming' ? 'success' : 'secondary' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td>
                        <div class="btn-group btn-group-sm gap-1" role="group">
                            <a href="{{ route('user.orders.warehouse', $order->id) }}"
                            class="btn btn-outline-primary d-flex align-items-center gap-1">
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="d-none d-md-inline">Alamat Gudang</span>
                            </a>
                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="10" class="text-center text-muted py-4">
                        Belum ada data barang masuk
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
