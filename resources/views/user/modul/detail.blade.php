@php
    use Carbon\Carbon;

    // Hitung sisa hari berdasarkan tanggal akhir
    $remainingDays = Carbon::today()->diffInDays(
        Carbon::parse($order->storage_end_date),
        false
    );

    // Jika sudah lewat tanggal, set ke 0
    $remainingDays = max(0, $remainingDays);

    $days = $remainingDays;

    $years  = intdiv($days, 365);
    $days   = $days % 365;

    $months = intdiv($days, 30);
    $days   = $days % 30;

    $durationText = [];

    if ($years > 0)  $durationText[] = $years . ' tahun';
    if ($months > 0) $durationText[] = $months . ' bulan';
    if ($days > 0)   $durationText[] = $days . ' hari';

    // fallback kalau sisa 0
    if (empty($durationText)) {
        $durationText[] = '0 hari';
    }

    $durationHuman = implode(' ', $durationText);
@endphp

<div class="mb-4 d-flex align-items-center">
    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm me-3">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h4 class="fw-semibold mb-0">Detail Pesanan</h4>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">

        {{-- HEADER --}}
        <div class="mb-4">
            <div class="text-muted small">Kode Pesanan</div>
            <h5 class="fw-bold mb-2">{{ $order->order_code }}</h5>

            @php
                $statusColor = match ($order->status) {
                    'stored'  => 'success',
                    'due'     => 'warning',
                    'expired' => 'secondary',
                    default   => 'secondary',
                };
            @endphp

            <span class="badge bg-{{ $statusColor }} px-3 py-2">
                {{ strtoupper($order->status) }}
            </span>
        </div>

        {{-- INFORMASI BARANG --}}
        <h6 class="fw-semibold mb-3">Informasi Barang</h6>
        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <div class="text-muted small">Nama Barang</div>
                <div class="fw-medium">{{ $order->item_name }}</div>
            </div>

            <div class="col-md-4">
                <div class="text-muted small">Tipe Barang</div>
                <div>{{ $order->item_type ?? '-' }}</div>
            </div>

            <div class="col-md-4">
                <div class="text-muted small">Ukuran Barang</div>
                <div>{{ $order->item_size ?? '-' }}</div>
            </div>

            <div class="col-md-4">
                <div class="text-muted small">Jumlah Barang</div>
                <div>{{ number_format($order->quantity) }}</div>
            </div>

            <div class="col-md-4">
                <div class="text-muted small">Pallet Digunakan</div>
                <div>{{ $order->pallet_estimated ?? 0 }}</div>
            </div>

        </div>

        {{-- INFORMASI PENYIMPANAN --}}
        <h6 class="fw-semibold mb-3">Informasi Penyimpanan</h6>
        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <div class="text-muted small">Durasi Penyimpanan</div>
                <div>{{ $durationHuman }}</div>
            </div>

            <div class="col-md-4">
                <div class="text-muted small">Tiba di Gudang</div>
                <div>
                    {{ $order->estimated_delivery
                        ? \Carbon\Carbon::parse($order->estimated_delivery)->format('d M Y')
                        : '-' }}
                </div>
            </div>

            <div class="col-md-4">
                <div class="text-muted small">Tanggal Akhir Simpan</div>
                <div>
                    {{ $order->storage_end_date
                        ? \Carbon\Carbon::parse($order->storage_end_date)->format('d M Y')
                        : '-' }}
                </div>
            </div>

        </div>

        {{-- INFORMASI PEMBAYARAN --}}
        <h6 class="fw-semibold mb-3">Informasi Pembayaran</h6>
        <div class="row g-3">

            <div class="col-md-6">
                <div class="text-muted small">Total Harga</div>
                <div class="fw-semibold fs-5">
                    Rp {{ number_format($order->price, 0, ',', '.') }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="text-muted small">Status Pembayaran</div>
                <div class="mt-1 p-2 rounded-3 bg-success text-white fw-semibold text-center">
                    {{ $order->status_bayar === 'lunas' ? 'LUNAS' : 'BELUM LUNAS' }}
                </div>
            </div>

        </div>

    </div>
</div>
