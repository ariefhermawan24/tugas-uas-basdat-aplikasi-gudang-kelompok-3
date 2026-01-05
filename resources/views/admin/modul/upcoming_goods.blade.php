@php
use Carbon\Carbon;

$orders = collect($orders ?? [])->sortBy(function ($order) {
    if (!$order->estimated_delivery) return 99;

    $estimated = Carbon::parse($order->estimated_delivery)->startOfDay();
    $today = now()->startOfDay();

    // 1 = Hari ini
    if ($estimated->eq($today)) return 1;

    // 2 = Terlambat
    if ($estimated->lt($today)) return 2;

    // 3 = Upcoming
    return 3;
});
@endphp


<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-semibold mb-1">Barang Akan Datang</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin', 'dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Barang Akan Datang
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
                        <td>
                            {{ $order->user->company_name ?? '-' }}
                        </td>
                        <td>{{ $order->item_name }}</td>
                        <td>{{ $order->item_type ?? '-' }}</td>
                        <td>{{ number_format($order->quantity) }}</td>

                        {{-- Estimasi Tiba --}}
                        <td class="fw-medium">
                            @if($diffDays !== null)
                            @if($diffDays > 0)
                            {{ $diffDays }} hari lagi
                            @elseif($diffDays == 0)
                            <span class="text-primary fw-semibold">Hari ini</span>
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

                        <td>
                            <div class="btn-group btn-group-sm gap-1" role="group">
                                @php
                                // aktif jika hari ini atau terlambat
                                $canArrive = $estimated && $diffDays <= 0;
                                    @endphp

                                    @if ($canArrive)
                                    <a href="#"
                                    class="btn btn-sm btn-outline-success d-flex align-items-center gap-1 btn-arrived"
                                    data-id="{{ $order->id }}">
                                    <i class="fas fa-check"></i>
                                        <span class="d-none d-md-inline">Barang Tiba</span>
                                    </a>

                                    {{-- Hidden Form --}}
                                    <form id="arrived-form-{{ $order->id }}"
                                        action="{{ route('admin.orders.arrived', $order->id) }}"
                                        method="POST"
                                        class="d-none">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                    @else
                                    <a class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 disabled">
                                        <i class="fas fa-clock"></i>
                                        <span class="d-none d-md-inline">Menunggu</span>
                                    </a>
                                    @endif

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
<script>
document.querySelectorAll('.btn-arrived').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault();

        const orderId = this.dataset.id;

        Swal.fire({
            title: 'Konfirmasi Barang Tiba',
            text: 'Apakah Anda yakin barang ini sudah tiba di gudang?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Barang Tiba',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document
                    .getElementById('arrived-form-' + orderId)
                    .submit();
            }
        });
    });
});
</script>
