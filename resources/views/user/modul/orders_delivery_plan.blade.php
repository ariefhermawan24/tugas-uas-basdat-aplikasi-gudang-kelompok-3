<div class="mb-4 d-flex align-items-center">
    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm me-3">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h4 class="fw-semibold mb-0">Rencana Pengiriman</h4>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">

        <div class="row g-4 align-items-start">

            {{-- DETAIL ORDER --}}
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <strong>Kode Pesanan</strong>
                    <div>{{ $order->order_code }}</div>
                </div>

                <div class="mb-3">
                    <strong>Nama Barang</strong>
                    <div>{{ $order->item_name }}</div>
                </div>

                <div class="mb-3">
                    <strong>Jenis Barang</strong>
                    <div>{{ $order->item_type }}</div>
                </div>

                <div class="mb-3">
                    <strong>Status Pembayaran</strong><br>
                    <span class="badge
                        {{ $order->status_bayar === 'lunas' ? 'bg-success' : 'bg-warning' }}">
                        {{ strtoupper($order->status_bayar) }}
                    </span>
                </div>
            </div>

            {{-- FORM PENGIRIMAN --}}
            <div class="col-12 col-md-6">
                <form method="POST"
                      action="{{ route('user.orders.delivery.store', $order->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Tanggal Perkiraan Pengiriman</label>
                        <input type="date"
                               name="estimated_delivery"
                               id="estimated_delivery"
                               class="form-control"
                               required>
                    </div>

                    {{-- ESTIMASI HARI TIBA --}}
                    <div class="mb-3 d-none" id="arrivalEstimate">
                        <div class="alert alert-info py-2 mb-0">
                            <i class="fas fa-clock me-1"></i>
                            Estimasi barang tiba dalam
                            <strong><span id="arrivalDays">0</span> hari</strong>
                        </div>
                    </div>

                    <button class="btn btn-success w-100 mt-2">
                        <i class="fas fa-truck me-1"></i>
                        Simpan Rencana Pengiriman
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>
<script>
const dateInput = document.getElementById('estimated_delivery');
const estimateBox = document.getElementById('arrivalEstimate');
const arrivalDaysText = document.getElementById('arrivalDays');

dateInput.addEventListener('change', function () {
    if (!this.value) {
        estimateBox.classList.add('d-none');
        return;
    }

    const today = new Date();
    const deliveryDate = new Date(this.value);

    // reset jam agar hitung hari akurat
    today.setHours(0,0,0,0);
    deliveryDate.setHours(0,0,0,0);

    const diffTime = deliveryDate - today;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    if (diffDays < 0) {
        estimateBox.classList.add('d-none');
        arrivalDaysText.textContent = 0;
        return;
    }

    arrivalDaysText.textContent = diffDays;
    estimateBox.classList.remove('d-none');
});
</script>
