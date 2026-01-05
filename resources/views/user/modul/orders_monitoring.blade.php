<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

    {{-- TITLE + BREADCRUMB --}}
    <div class="w-100">
        <h4 class="fw-semibold mb-1">Monitoring Pesanan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-10 small">
                <li class="breadcrumb-item">
                    <a href="{{ route('user', 'dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Monitoring Pesanan
                </li>
            </ol>
        </nav>
    </div>

    {{-- SEARCH --}}
    <div class="w-100 d-flex justify-content-md-end">
        <div class="input-group input-group-sm shadow-sm rounded-pill overflow-hidden w-100"
            style="max-width: 360px;">
            <span class="input-group-text bg-white border-0 ps-3">
                <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text"
                id="orderSearch"
                class="form-control border-0 pe-3"
                placeholder="Cari pesanan...">
        </div>
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
                        <th>Pallet</th>
                        <th>Durasi</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                @php
                $orders = $orders->sortBy(function ($order) {
                return match ($order->status) {
                'expired' => 1,
                'due' => 2,
                'stored' => 3,
                default => 99,
                };
                });

                @endphp
                <tbody id="orderTable">
                    @forelse ($orders as $order)
                    @php
                        $endDate = \Carbon\Carbon::parse($order->storage_end_date);
                        $remainingDays = now()->startOfDay()->diffInDays($endDate, false);
                    @endphp
                    <tr class="order-row">
                        <td>{{ $loop->iteration }}</td>

                        <td class="fw-medium">
                            {{ $order->order_code }}
                        </td>

                        <td>
                            {{ $order->item_name }}
                        </td>

                        <td>
                            {{ $order->item_type ?? '-' }}
                        </td>

                        <td>
                            {{ number_format($order->quantity) }}
                        </td>

                        <td>
                            {{ $order->pallet_estimated ?? 0 }}
                        </td>

                        <td>
                            @if ($remainingDays < 0)
                                <span class="text-danger fw-semibold">Lewat {{ abs($remainingDays) }} hari</span>
                            @else
                                {{ $remainingDays }} hari
                            @endif
                        </td>

                        <td class="fw-semibold">
                            Rp {{ number_format($order->price, 0, ',', '.') }}
                        </td>

                        <td>
                            @php
                            $statusColor = match ($order->status) {
                            'stored' => 'success', // sudah tersimpan di gudang
                            'due' => 'warning', // hampir kedaluwarsa
                            'expired' => 'dark', // kedaluwarsa
                            default => 'secondary',
                            };
                            @endphp

                            <span class="badge bg-{{ $statusColor }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm gap-1" role="group">

                                {{-- STORED --}}
                                @if ($order->status === 'stored')

                                {{-- DETAIL --}}
                                <a href="{{ route('user.orders.show', $order->id) }}"
                                    class="btn btn-outline-primary d-flex align-items-center gap-1">
                                    <i class="fas fa-eye"></i>
                                    <span class="d-none d-md-inline">Detail</span>
                                </a>

                                {{-- OUTGOING --}}
                                <a href="{{ route('user.orders.outgoing', $order->id) }}"
                                    class="btn btn-outline-warning d-flex align-items-center gap-1">
                                    <i class="fas fa-truck"></i>
                                    <span class="d-none d-md-inline">Outgoing</span>
                                </a>
                                @else
                                {{-- RENEW --}}
                                <a href="{{ route('user.orders.renew', $order->id) }}"
                                    class="btn btn-outline-success d-flex align-items-center gap-1">
                                    <i class="fas fa-redo"></i>
                                    <span class="d-none d-md-inline">Renew</span>
                                </a>

                                {{-- OUTGOING --}}
                                <a href="{{ route('user.orders.outgoing', $order->id) }}"
                                    class="btn btn-outline-warning d-flex align-items-center gap-1">
                                    <i class="fas fa-truck"></i>
                                    <span class="d-none d-md-inline">Outgoing</span>
                                </a>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">
                            Belum ada data pesanan
                        </td>
                    </tr>
                    @endforelse
                    <tr id="noResultRow" style="display:none;">
                        <td colspan="10" class="text-center text-muted py-4">
                            Data yang dicari tidak tersedia
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
<script>
    const searchInput = document.getElementById('orderSearch');
    const rows = document.querySelectorAll('#orderTable .order-row');
    const noResultRow = document.getElementById('noResultRow');

    searchInput.addEventListener('input', function() {
        const keyword = this.value.toLowerCase().trim();
        let found = false;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();

            if (keyword === '' || text.includes(keyword)) {
                row.style.display = '';
                if (keyword !== '') found = true;
            } else {
                row.style.display = 'none';
            }
        });

        // LOGIKA TAMPILKAN PESAN
        if (keyword !== '' && !found) {
            noResultRow.style.display = '';
        } else {
            noResultRow.style.display = 'none';
        }
    });
</script>
