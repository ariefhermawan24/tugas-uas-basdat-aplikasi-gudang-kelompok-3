<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

    {{-- TITLE + BREADCRUMB --}}
    <div class="w-100">
        <h4 class="fw-semibold mb-1">Pesanan Jatuh Tempo</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-10 small">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin', 'dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Pesanan Jatuh Tempo
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
                        <th>Perusahaan</th>
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

                <tbody id="orderTable">
                    @forelse ($orders as $order)
                    <tr class="order-row">
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
                            {{ $order->item_type ?? '-' }}
                        </td>

                        <td>
                            {{ number_format($order->quantity) }}
                        </td>

                        <td>
                            {{ $order->pallet_estimated ?? 0 }}
                        </td>

                        <td>
                            {{ $order->storage_duration }} hari
                        </td>

                        <td class="fw-semibold">
                            Rp {{ number_format($order->price, 0, ',', '.') }}
                        </td>

                        <td>
                            @php
                                $statusColor = match ($order->status) {
                                    'due'       => 'warning',
                                    default     => 'secondary',
                                };
                            @endphp

                            <span class="badge bg-{{ $statusColor }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm gap-1" role="group">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->user->phone) }}"
                                target="_blank"
                                class="btn btn-outline-success d-flex align-items-center gap-1">
                                    <i class="fab fa-whatsapp"></i>
                                    <span class="d-none d-md-inline">Hubungi Pengguna</span>
                                </a>
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

searchInput.addEventListener('input', function () {
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
