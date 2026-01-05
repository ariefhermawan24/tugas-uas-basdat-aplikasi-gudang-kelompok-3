@php
    use Carbon\Carbon;
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-semibold mb-1">Barang Keluar</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item">
                    <a href="{{ route('user', 'dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Barang Keluar
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
                                <th>Status Keluar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
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
                    <td>{{ $order->destination ?? '-' }}</td>

                    {{-- Status Keluar --}}
                    <td>
                        @php
                            $keluarColor = match ($order->status_keluar) {
                                'di_gudang'     => 'secondary',
                                'keluar_gudang' => 'warning',
                                default         => 'secondary',
                            };
                        @endphp

                        <span class="badge bg-{{ $keluarColor }}">
                            {{ $order->status_keluar ? str_replace('_', ' ', ucfirst($order->status_keluar)) : '-' }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td>
                        <span class="badge bg-{{ $order->status === 'outgoing' ? 'success' : 'secondary' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td>
                        <div class="btn-group btn-group-sm gap-1" role="group">

                            <button type="button"
                                class="btn btn-outline-success d-flex align-items-center gap-1 btn-complete-order"
                                data-id="{{ $order->id }}"
                                {{ $order->status_keluar !== 'keluar_gudang' ? 'disabled' : '' }}>
                                <i class="fas fa-check-circle"></i>
                                <span class="d-none d-md-inline">Barang Sampai</span>
                            </button>

                            <form id="complete-form-{{ $order->id }}"
                                action="{{ route('user.orders.complete', $order->id) }}"
                                method="POST"
                                class="d-none">
                                @csrf
                                @method('PATCH')
                            </form>

                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="10" class="text-center text-muted py-4">
                        Belum ada data barang Keluar
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
<script>
document.querySelectorAll('.btn-complete-order').forEach(btn => {
    btn.addEventListener('click', function () {
        const orderId = this.dataset.id;

        Swal.fire({
            title: 'Konfirmasi Barang Sampai',
            text: 'Pastikan barang benar-benar sudah sampai di tujuan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Sudah Sampai',
            cancelButtonText: 'Batal',
        }).then(result => {
            if (result.isConfirmed) {
                document.getElementById(`complete-form-${orderId}`).submit();
            }
        });
    });
});
</script>
