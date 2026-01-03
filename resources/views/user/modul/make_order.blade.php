<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-semibold mb-1">Make Order</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item">
                    <a href="{{ route('user', 'dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Make Order
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
                        <th>Code Order</th>
                        <th>Nama Item</th>
                        <th>Tipe Item</th>
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
                                @if (in_array($order->status, ['checking']))
                                    {{-- EDIT --}}
                                    <a href="{{ route('user.orders.edit', $order->id) }}"
                                    class="btn btn-outline-primary d-flex align-items-center gap-1">
                                        <i class="fas fa-edit"></i>
                                        <span class="d-none d-md-inline">Edit</span>
                                    </a>

                                    {{-- BAYAR --}}
                                    <a href="{{ route('user', 'orders_payment') }}"
                                    class="btn btn-outline-success d-flex align-items-center gap-1">
                                        <i class="fas fa-credit-card"></i>
                                        <span class="d-none d-md-inline">Bayar</span>
                                    </a>

                                @else
                                    {{-- PENGIRIMAN --}}
                                    <a href="{{ route('user', 'orders_delivery_plan') }}"
                                    class="btn btn-outline-success d-flex align-items-center gap-1">
                                        <i class="fas fa-truck"></i>
                                        <span class="d-none d-md-inline">Pengiriman</span>
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
                </tbody>
            </table>
        </div>

    </div>
</div>
