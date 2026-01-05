<div class="mb-4 d-flex align-items-center">
    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm me-3">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h4 class="fw-semibold mb-0">Bayar Pesanan</h4>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">

        <form method="POST"
              action="{{ route('user.orders.payment.store', $order->id) }}"
              enctype="multipart/form-data">

            @csrf

            <div class="row g-4" id="paymentLayout">

                {{-- FORM (FULL WIDTH DEFAULT) --}}
                <div class="col-12" id="formColumn">
                    {{-- DETAIL ORDER --}}
                    <div class="mb-3">
                        <strong>Kode Pesanan</strong>
                        <div>{{ $order->order_code }}</div>
                    </div>

                    <div class="mb-3">
                        <strong>Nama Barang</strong>
                        <div>{{ $order->item_name }}</div>
                    </div>

                    <div class="mb-3">
                        <strong>Total Pembayaran</strong>
                        <div>Rp {{ number_format($order->price, 0, ',', '.') }}</div>
                    </div>

                    <div class="mb-3">
                        <strong>Status Pembayaran</strong><br>
                        <span class="badge bg-warning">
                            {{ strtoupper($order->status_bayar) }}
                        </span>
                    </div>
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
                        Kirim Bukti Bayar
                    </button>
                </div>

                {{-- PREVIEW (SEMBUNYI AWAL) --}}
                <div class="col-12 d-none" id="previewColumn">
                    <label class="form-label text-muted">Preview Bukti Bayar</label>
                    <div class="border rounded-4 p-3 text-center bg-light">
                        <img id="previewImage"
                             class="img-fluid rounded-3"
                             style="max-height: 300px;">
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>

<script>
const fileInput = document.getElementById('bukti_bayar');
const previewColumn = document.getElementById('previewColumn');
const previewImage = document.getElementById('previewImage');
const formColumn = document.getElementById('formColumn');

fileInput.addEventListener('change', function (e) {
    const file = e.target.files[0];

    if (!file) {
        // RESET KE 1 KOLOM
        previewColumn.classList.add('d-none');
        formColumn.className = 'col-12';
        previewColumn.className = 'col-12 d-none';
        previewImage.src = '';
        return;
    }

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

        // RESPONSIVE LAYOUT
        if (window.innerWidth >= 768) {
            // DESKTOP: 2 KOLOM
            formColumn.className = 'col-md-7 col-12';
            previewColumn.className = 'col-md-5 col-12';
        } else {
            // MOBILE: STACK
            formColumn.className = 'col-12 order-2';
            previewColumn.className = 'col-12 order-1';
        }
    };

    reader.readAsDataURL(file);
});
</script>
