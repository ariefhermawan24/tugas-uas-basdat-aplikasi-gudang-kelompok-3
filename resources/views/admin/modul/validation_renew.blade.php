<div class="mb-4 d-flex align-items-center">
    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm me-3">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h4 class="fw-semibold mb-0">Validasi Perpanjangan Pesanan</h4>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">

        <div class="row g-4 align-items-start">

            {{-- DETAIL RENEW --}}
            <div class="col-12 col-md-6">

                <div class="mb-3">
                    <strong>Kode Pesanan</strong>
                    <div>{{ $order->order_code }}</div>
                </div>

                <div class="mb-3">
                    <strong>Perusahaan</strong>
                    <div>{{ $order->user->company_name ?? '-' }}</div>
                </div>

                <div class="mb-3">
                    <strong>Nama Barang</strong>
                    <div>{{ $order->item_name }}</div>
                </div>

                <div class="mb-3">
                    <strong>Akhir Penyimpanan Saat Ini</strong>
                    <div>
                        {{ \Carbon\Carbon::parse($order->storage_end_date)
                            ->locale('id')
                            ->isoFormat('D MMMM YYYY') }}
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Perpanjangan</strong>
                    <div>
                        {{ $order->renew_extend_days }} hari
                        &nbsp;→&nbsp;
                        {{ \Carbon\Carbon::parse($order->renew_end_date)
                            ->locale('id')
                            ->isoFormat('D MMMM YYYY') }}
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Total Biaya Perpanjangan</strong>
                    <div class="fw-semibold">
                        Rp {{ number_format($order->renew_price, 0, ',', '.') }}
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Status Pembayaran</strong><br>
                    <span class="badge bg-warning">
                        {{ strtoupper($order->status_bayar) }}
                    </span>
                </div>

                {{-- FORM VALIDASI --}}
                <form method="POST"
                      action="{{ route('admin.orders.renew.validation.store', $order->id) }}"
                      class="d-flex gap-2 mt-4">
                    @csrf

                    <button type="submit"
                            name="action"
                            value="approve"
                            class="btn btn-success flex-fill">
                        <i class="fas fa-check me-1"></i>
                        Approve
                    </button>

                    <button type="submit"
                            name="action"
                            value="reject"
                            class="btn btn-danger flex-fill">
                        <i class="fas fa-times me-1"></i>
                        Reject
                    </button>
                </form>

            </div>

            {{-- PREVIEW BUKTI BAYAR --}}
            <div class="col-12 col-md-6">
                <label class="form-label text-muted">Bukti Pembayaran Perpanjangan</label>
                <div class="border rounded-4 p-3 text-center bg-light">
                    <img src="{{ asset('storage/bukti-bayar/' . $order->bukti_bayar) }}"
                    class="img-fluid rounded-3"
                    style="max-height: 360px;"
                    alt="Bukti Pembayaran">

                </div>
            </div>

        </div>

    </div>
</div>
