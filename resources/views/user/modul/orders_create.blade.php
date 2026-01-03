<div class="mb-4 d-flex align-items-center">
    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm me-3">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h4 class="fw-semibold mb-0">Buat Pesanan</h4>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">

        <form method="POST" action="{{ route('user.order.store') }}">
            @csrf

            <div class="row g-3">

                <!-- ORDER CODE -->
                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Kode Order</label>
                    <input type="text"
                        class="form-control"
                        value="ORD-{{ now()->format('YmdHis') }}"
                        disabled>
                    <input type="hidden"
                        name="order_code"
                        value="ORD-{{ now()->format('YmdHis') }}">
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Nama Barang</label>
                    <input type="text"
                        name="item_name"
                        class="form-control"
                        placeholder="Contoh: TV LED Samsung 43 Inch"
                        required>
                    <small class="text-muted">
                        Nama barang yang akan disimpan di gudang
                    </small>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Tipe Barang</label>
                    <input type="text"
                        name="item_type"
                        class="form-control"
                        placeholder="Contoh: Elektronik / Furniture / Mesin"
                        required>
                    <small class="text-muted">
                        Kategori atau jenis utama barang
                    </small>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Jumlah Barang</label>
                    <input type="number"
                        name="quantity"
                        class="form-control"
                        min="1"
                        placeholder="Masukkan total unit barang"
                        required>
                    <small class="text-muted">
                        Total unit barang yang akan disimpan
                    </small>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Ukuran Barang</label>
                    <select name="item_size"
                        id="itemSize"
                        class="form-select"
                        required>
                        <option value="">-- Pilih Ukuran --</option>
                        <option value="small">Kecil</option>
                        <option value="medium">Menengah</option>
                        <option value="large">Besar</option>
                    </select>
                    <small class="text-muted">
                        Digunakan untuk menghitung kebutuhan pallet
                    </small>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Tanggal Akhir Sewa</label>
                    <input type="date"
                        name="storage_end_date"
                        id="endDate"
                        class="form-control"
                        required>
                    <small class="text-muted">
                        Tanggal terakhir barang disimpan di gudang
                    </small>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Jumlah Pallet</label>
                    <input type="number"
                        id="pallet"
                        class="form-control bg-light"
                        placeholder="Dihitung otomatis"
                        readonly>
                    <input type="hidden"
                        name="pallet_estimated"
                        id="palletHidden">
                    <small class="text-muted">
                        Berdasarkan ukuran dan jumlah barang
                    </small>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Durasi (Hari)</label>
                    <input type="number"
                        id="duration"
                        class="form-control bg-light"
                        placeholder="Dihitung otomatis"
                        readonly>
                    <input type="hidden" name="storage_duration" id="durationHidden">
                    <small class="text-muted">
                        Durasi dihitung dari hari ini hingga tanggal akhir sewa
                    </small>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label">Total Harga</label>
                    <input type="text"
                        id="price"
                        class="form-control bg-light fw-semibold"
                        placeholder="Dihitung otomatis"
                        readonly>
                    <input type="hidden" name="price" id="priceHidden">
                    <small class="text-muted">
                        Harga = Pallet × Durasi × Tarif harian
                    </small>
                </div>

            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>
                    Simpan Pesanan
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

    // EVENTS
    quantityInput.addEventListener('input', calculateAll);
    sizeInput.addEventListener('change', calculateAll);
    endDateInput.addEventListener('change', calculateAll);
</script>
