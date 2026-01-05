<div class="mb-4 d-flex align-items-center">
    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm me-3">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h4 class="fw-semibold mb-0">Rencana Barang Keluar</h4>
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
                    <strong>Akhir Masa Penyimpanan</strong>
                    <div>
                        {{ \Carbon\Carbon::parse($order->storage_end_date)
                            ->locale('id')
                            ->isoFormat('D MMMM YYYY') }}
                    </div>
                </div>

            </div>

            {{-- FORM PENGIRIMAN --}}
            <div class="col-12 col-md-6">
                <form method="POST"
                    action="{{ route('user.orders.outgoing.store', $order->id) }}">
                    @csrf

                    {{-- PERKIRAAN SAMPAI --}}
                    <div class="mb-3">
                        <label class="form-label">Perkiraan Sampai Lokasi</label>
                        <input type="date"
                            name="estimated_arrival"
                            id="estimated_arrival"
                            class="form-control"
                            required>
                    </div>

                    {{-- ESTIMASI HARI --}}
                    <div class="mb-3 d-none" id="arrivalEstimate">
                        <div class="alert alert-info py-2 mb-0">
                            <i class="fas fa-clock me-1"></i>
                            Estimasi barang tiba dalam
                            <strong><span id="arrivalDays">0</span> hari</strong>
                        </div>
                    </div>

                    {{-- LOKASI TUJUAN --}}
                    <div class="mb-3">
                        <label class="form-label">Lokasi Tujuan</label>
                        <textarea name="destination"
                                class="form-control"
                                rows="3"
                                placeholder="Contoh: Gudang Cabang Surabaya"
                                required></textarea>
                    </div>

                    <button class="btn btn-warning w-100 mt-2">
                        <i class="fas fa-truck me-1"></i>
                        Proses Keluar
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>
<script>
const dateInput = document.getElementById('estimated_arrival');
const estimateBox = document.getElementById('arrivalEstimate');
const arrivalDaysText = document.getElementById('arrivalDays');

dateInput.addEventListener('change', function () {
    if (!this.value) {
        estimateBox.classList.add('d-none');
        return;
    }

    const today = new Date();
    const arrivalDate = new Date(this.value);

    today.setHours(0,0,0,0);
    arrivalDate.setHours(0,0,0,0);

    const diffDays = Math.ceil(
        (arrivalDate - today) / (1000 * 60 * 60 * 24)
    );

    if (diffDays < 0) {
        estimateBox.classList.add('d-none');
        return;
    }

    arrivalDaysText.textContent = diffDays;
    estimateBox.classList.remove('d-none');
});
</script>
