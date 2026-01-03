<div class="mb-4 d-flex align-items-center">
    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm me-3">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h4 class="fw-semibold mb-0">Buat Pesanan</h4>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">

        <form method="POST" action="{{ route('user.orders.update', $order->id) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <!-- ORDER CODE -->
                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Kode Order</label>
                    <input type="text"
                        class="form-control bg-light"
                        value="{{ $order->order_code }}"
                        readonly>
                </div>

                <!-- ITEM NAME -->
                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Nama Barang</label>
                    <input type="text"
                        name="item_name"
                        class="form-control"
                        value="{{ $order->item_name }}"
                        required>
                </div>

                <!-- ITEM TYPE -->
                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Tipe Barang</label>
                    <input type="text"
                        name="item_type"
                        class="form-control"
                        value="{{ $order->item_type }}"
                        required>
                </div>

                <!-- QUANTITY -->
                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Jumlah Barang</label>
                    <input type="number"
                        name="quantity"
                        id="quantity"
                        class="form-control"
                        min="1"
                        value="{{ $order->quantity }}"
                        required>
                </div>

                <!-- ITEM SIZE -->
                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Ukuran Barang</label>
                    <select name="item_size"
                        id="itemSize"
                        class="form-select"
                        required>
                        <option value="small" {{ $order->item_size === 'small' ? 'selected' : '' }}>Kecil</option>
                        <option value="medium" {{ $order->item_size === 'medium' ? 'selected' : '' }}>Menengah</option>
                        <option value="large" {{ $order->item_size === 'large' ? 'selected' : '' }}>Besar</option>
                    </select>
                </div>

                <!-- END DATE -->
                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Tanggal Akhir Sewa</label>
                    <input type="date"
                        name="storage_end_date"
                        id="endDate"
                        class="form-control"
                        value="{{ $order->storage_end_date }}"
                        required>
                </div>

                <!-- PALLET -->
                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Jumlah Pallet</label>
                    <input type="number"
                        id="pallet"
                        class="form-control bg-light"
                        readonly>
                    <input type="hidden"
                        name="pallet_estimated"
                        id="palletHidden"
                        value="{{ $order->pallet_estimated }}">
                </div>

                <!-- DURATION -->
                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Durasi (Hari)</label>
                    <input type="number"
                        id="duration"
                        class="form-control bg-light"
                        readonly>
                    <input type="hidden"
                        name="storage_duration"
                        id="durationHidden"
                        value="{{ $order->storage_duration }}">
                </div>

                <!-- PRICE -->
                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Total Harga</label>
                    <input type="text"
                        id="price"
                        class="form-control bg-light fw-semibold"
                        readonly>
                    <input type="hidden"
                        name="price"
                        id="priceHidden"
                        value="{{ $order->price }}">
                </div>

            </div>

            <div class="d-flex justify-content-end mt-4 gap-2">
                <a href="{{ route('user', 'make_order') }}" class="btn btn-light">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>
                    Update Pesanan
                </button>
            </div>

        </form>

    </div>
</div>

<script>
    const PRICE_PER_PALLET_PER_DAY = 1000;

    // Kapasitas pallet (REALISTIS)
    const PALLET_CAPACITY = {
        large: 2,
        medium: 6,
        small: 12
    };

    // ELEMENTS
    const quantityInput = document.querySelector('input[name="quantity"]');
    const sizeInput = document.getElementById('itemSize');

    const palletInput = document.getElementById('pallet');
    const palletHidden = document.getElementById('palletHidden');

    const endDateInput = document.getElementById('endDate');
    const durationInput = document.getElementById('duration');
    const durationHidden = document.getElementById('durationHidden');

    const priceInput = document.getElementById('price');
    const priceHidden = document.getElementById('priceHidden');

    function calculateAll() {
        const qty = parseInt(quantityInput.value) || 0;
        const size = sizeInput.value;

        // === HITUNG PALLET ===
        if (!qty || !size) {
            palletInput.value = '';
            priceInput.value = '';
            return;
        }

        const capacity = PALLET_CAPACITY[size];
        const pallets = Math.ceil(qty / capacity);

        palletInput.value = pallets;
        palletHidden.value = pallets;

        // === HITUNG DURASI ===
        if (!endDateInput.value) return;

        const today = new Date();
        const end = new Date(endDateInput.value);

        today.setHours(0, 0, 0, 0);

        if (end <= today) {
            durationInput.value = '';
            priceInput.value = '';
            return;
        }

        const days = Math.ceil((end - today) / (1000 * 60 * 60 * 24));

        durationInput.value = days;
        durationHidden.value = days;

        // === HITUNG HARGA ===
        const totalPrice = pallets * days * PRICE_PER_PALLET_PER_DAY;

        priceInput.value = 'Rp ' + totalPrice.toLocaleString('id-ID');
        priceHidden.value = totalPrice;
    }

    document.addEventListener('DOMContentLoaded', () => {
        calculateAll(); // AUTO hitung saat edit dibuka
    });

    // EVENTS
    quantityInput.addEventListener('input', calculateAll);
    sizeInput.addEventListener('change', calculateAll);
    endDateInput.addEventListener('change', calculateAll);
</script>
