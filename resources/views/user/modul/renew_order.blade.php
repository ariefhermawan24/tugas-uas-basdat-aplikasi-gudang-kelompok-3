@php
use Carbon\Carbon;

$oldEndDate = Carbon::parse($order->storage_end_date)->startOfDay();
@endphp

<div class="mb-4 d-flex align-items-center">
    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm me-3">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h4 class="fw-semibold mb-0">Perpanjang Pesanan</h4>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">

        <form method="POST"
            action="{{ route('user.orders.renew.store', $order->id) }}"
            enctype="multipart/form-data">
            @csrf

            <div class="row g-4" id="renewLayout">

                {{-- FORM --}}
                <div class="col-12" id="formColumn">

                    {{-- INFO ORDER --}}
                    <div class="mb-3">
                        <strong>Kode Pesanan</strong>
                        <div>{{ $order->order_code }}</div>
                    </div>

                    <div class="mb-3">
                        <strong>Nama Barang</strong>
                        <div>{{ $order->item_name }}</div>
                    </div>

                    <div class="mb-3">
                        <strong>Akhir Masa Penyimpanan Saat Ini</strong>
                        <div>{{ $oldEndDate->locale('id')->isoFormat('D MMMM YYYY') }}</div>
                    </div>

                    {{-- TANGGAL BARU --}}
                    <div class="mb-3">
                        <label class="form-label">Perpanjang Sampai Tanggal</label>
                        <input type="date"
                            name="new_storage_end_date"
                            id="newEndDate"
                            class="form-control"
                            min="{{ $oldEndDate->addDay()->format('Y-m-d') }}"
                            required>
                    </div>

                    {{-- TAMBAHAN HARI --}}
                    <div class="mb-3">
                        <label class="form-label">Tambahan Durasi</label>
                        <input type="text"
                            id="extraDays"
                            class="form-control bg-light"
                            readonly>
                        <input type="hidden"
                            name="extend_days"
                            id="extraDaysHidden">
                    </div>

                    {{-- TOTAL BIAYA --}}
                    <div class="mb-3">
                        <label class="form-label">Total Biaya Perpanjangan</label>
                        <input type="text"
                            id="renewPrice"
                            class="form-control bg-light fw-semibold"
                            readonly>
                        <input type="hidden"
                            name="renew_price"
                            id="renewPriceHidden">
                    </div>

                    {{-- UPLOAD BUKTI BAYAR --}}
                    <div class="mb-3">
                        <label class="form-label">Bukti Pembayaran</label>
                        <input type="file"
                            name="bukti_bayar"
                            id="bukti_bayar"
                            class="form-control"
                            accept="image/*"
                            required>
                    </div>

                    <button class="btn btn-success w-100">
                        <i class="fas fa-upload me-1"></i>
                        Ajukan Perpanjangan
                    </button>

                </div>

                {{-- PREVIEW --}}
                <div class="col-12 col-md-5 d-none" id="previewColumn">
                    <label class="form-label text-muted">Preview Bukti Bayar</label>
                    <div class="border rounded-4 p-3 text-center bg-light">
                        <img id="previewImage"
                            class="img-fluid rounded-3"
                            style="max-height: 320px;">
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>
<div id="renewData"
     data-pallet="{{ $order->pallet_estimated }}"
     data-old-end-date="{{ $oldEndDate->format('Y-m-d') }}">
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ======================
       DATA RENEW
    ====================== */
    const container = document.getElementById('renewData');
    if (!container) return;

    const PRICE_PER_PALLET_PER_DAY = 1000;
    const PALLET_COUNT = parseInt(container.dataset.pallet, 10);
    const oldEndDate = new Date(container.dataset.oldEndDate);

    /* ======================
       ELEMENTS
    ====================== */
    const newEndDateInput = document.getElementById('newEndDate');
    const extraDaysInput = document.getElementById('extraDays');
    const extraDaysHidden = document.getElementById('extraDaysHidden');
    const priceInput = document.getElementById('renewPrice');
    const priceHidden = document.getElementById('renewPriceHidden');

    const fileInput = document.getElementById('bukti_bayar');
    const previewColumn = document.getElementById('previewColumn');
    const previewImage = document.getElementById('previewImage');

    const formColumn = document.getElementById('formColumn');

    /* ======================
       HITUNG EXTEND
    ====================== */
    newEndDateInput.addEventListener('change', function () {
        if (!this.value) return;

        const newEnd = new Date(this.value);
        newEnd.setHours(0, 0, 0, 0);

        const diffDays = Math.ceil(
            (newEnd - oldEndDate) / (1000 * 60 * 60 * 24)
        );

        if (diffDays <= 0) {
            extraDaysInput.value = '';
            priceInput.value = '';
            return;
        }

        const totalPrice = diffDays * PALLET_COUNT * PRICE_PER_PALLET_PER_DAY;

        extraDaysInput.value = diffDays + ' hari';
        extraDaysHidden.value = diffDays;

        priceInput.value = 'Rp ' + totalPrice.toLocaleString('id-ID');
        priceHidden.value = totalPrice;
    });

    /* ======================
       PREVIEW GAMBAR (FIX UTAMA)
    ====================== */
    fileInput.addEventListener('change', function (e) {
        const file = e.target.files[0];

        // RESET JIKA TIDAK ADA FILE
        if (!file) {
            previewColumn.classList.add('d-none');
            formColumn.className = 'col-12 col-md-7';
            previewImage.src = '';
            return;
        }

        // VALIDASI IMAGE
        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar');
            e.target.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            previewImage.src = event.target.result;

            // TAMPILKAN PREVIEW
            previewColumn.classList.remove('d-none');

            // DESKTOP: 2 KOLOM RAPI
            if (window.innerWidth >= 768) {
                formColumn.className = 'col-md-7 col-12';
                previewColumn.className = 'col-md-5 col-12';
            }
            // MOBILE: STACK NORMAL
            else {
                formColumn.className = 'col-12';
                previewColumn.className = 'col-12 mt-3';
            }
        };

        reader.readAsDataURL(file);
    });

});
</script>
