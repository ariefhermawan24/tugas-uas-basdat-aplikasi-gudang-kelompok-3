<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-semibold mb-1">membuat pesanan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item">
                    <a href="{{ route('user', 'dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    membuat pesanan
                </li>
            </ol>
        </nav>
    </div>

    <a href="{{ route('user', 'orders_create') }}"
        class="btn btn-primary btn-sm">
        <i class="fas fa-plus me-1"></i>
        Buat Pesanan
    </a>
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

                <tbody>
                    @forelse ($orders as $order)
                    <tr>
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
                            {{ $order->storage_duration }} hari
                        </td>

                        <td class="fw-semibold">
                            Rp {{ number_format($order->price, 0, ',', '.') }}
                        </td>

                        <td>
                            @php
                            $statusColor = match($order->status) {
                            'checking' => 'info',
                            'pending' => 'warning',
                            'approved' => 'primary',
                            'rejected' => 'danger',
                            default => 'secondary',
                            };
                            @endphp

                            <span class="badge bg-{{ $statusColor }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm gap-1" role="group">
                                {{-- CHECKING --}}
                                @if ($order->status === 'checking')

                                <a href="{{ route('user.orders.edit', $order->id) }}"
                                    class="btn btn-outline-primary d-flex align-items-center gap-1">
                                    <i class="fas fa-edit"></i>
                                    <span class="d-none d-md-inline">Edit</span>
                                </a>

                                <a href="{{ route('user.orders.payment', $order->id) }}"
                                    class="btn btn-outline-success d-flex align-items-center gap-1">
                                    <i class="fas fa-credit-card"></i>
                                    <span class="d-none d-md-inline">Bayar</span>
                                </a>

                                {{-- PENDING --}}
                                @elseif ($order->status === 'pending')

                                <a href="#"
                                    class="btn btn-outline-warning d-flex align-items-center gap-1 btn-cancel-order"
                                    data-id="{{ $order->id }}">
                                    <i class="fas fa-ban"></i>
                                    <span class="d-none d-md-inline">Batal</span>
                                </a>

                                <form id="cancel-form-{{ $order->id }}"
                                    action="{{ route('user.orders.cancel', $order->id) }}"
                                    method="POST"
                                    class="d-none">
                                    @csrf
                                    @method('PATCH')
                                </form>

                                {{-- APPROVED --}}
                                @elseif ($order->status === 'approved')
                                <a href="{{ route('user.orders.delivery', $order->id) }}"
                                    class="btn btn-outline-success d-flex align-items-center gap-1">
                                    <i class="fas fa-truck"></i>
                                    <span class="d-none d-md-inline">Pengiriman</span>
                                </a>
                                {{-- REJECTED --}}
                                @elseif ($order->status === 'rejected')

                                <a href="#"
                                    class="btn btn-outline-danger d-flex align-items-center gap-1 btn-delete-order"
                                    data-id="{{ $order->id }}">
                                    <i class="fas fa-trash"></i>
                                    <span class="d-none d-md-inline">Hapus</span>
                                </a>

                                <form id="delete-form-{{ $order->id }}"
                                    action="{{ route('user.orders.destroy', $order->id) }}"
                                    method="POST"
                                    class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
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
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
    /* ======================
   BATAL PESANAN
====================== */
    document.querySelectorAll('.btn-cancel-order').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const orderId = this.dataset.id;

            Swal.fire({
                title: 'Batalkan Pesanan?',
                text: 'Pesanan akan dibatalkan dan tidak bisa diproses lebih lanjut.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tidak',
                confirmButtonColor: '#f59e0b'
            }).then((result) => {
                if (result.isConfirmed) {
                    document
                        .getElementById('cancel-form-' + orderId)
                        .submit();
                }
            });
        });
    });

    /* ======================
       HAPUS PESANAN
    ====================== */
    document.querySelectorAll('.btn-delete-order').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const orderId = this.dataset.id;

            Swal.fire({
                title: 'Hapus Pesanan?',
                text: 'Pesanan akan dihapus permanen dan tidak dapat dikembalikan.',
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626'
            }).then((result) => {
                if (result.isConfirmed) {
                    document
                        .getElementById('delete-form-' + orderId)
                        .submit();
                }
            });
        });
    });
</script>
