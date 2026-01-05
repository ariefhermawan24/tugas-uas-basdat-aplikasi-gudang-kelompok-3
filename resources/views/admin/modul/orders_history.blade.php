<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-semibold mb-1">sejarah pesanan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item">
                    <a href="{{ route('user', 'dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Sejarah Pesanan
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
                            $statusColor = match($order->status) {
                            'outgoing' => 'warning',
                            'expired' => 'dark',
                            'completed' => 'success',
                            'canceled' => 'danger',
                            default => 'secondary',
                            };
                            @endphp

                            <span class="badge bg-{{ $statusColor }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm gap-1" role="group">
                                <button type="button"
                                    class="btn btn-outline-danger d-flex align-items-center gap-1 btn-delete-order"
                                    data-id="{{ $order->id }}"
                                    data-code="{{ $order->order_code }}">
                                    <i class="fas fa-trash"></i>
                                    <span class="d-none d-md-inline">Hapus</span>
                                </button>

                                <form id="delete-form-{{ $order->id }}"
                                    action="{{ route('admin.orders.destroy', $order->id) }}"
                                    method="POST"
                                    class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
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
