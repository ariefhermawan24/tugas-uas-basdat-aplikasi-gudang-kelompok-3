@php
    $mapsLink = 'https://maps.google.com/?q=Jl. Raya Industri No. 45 Surakarta';
@endphp

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">
        <i class="fas fa-arrow-left me-1"></i>
    </a>
    <h4 class="fw-semibold mb-0">Alamat Gudang</h4>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">

        <div class="row g-4 align-items-center">

            {{-- KIRI : DETAIL --}}
            <div class="col-md-7 text-start">

                <h5 class="fw-semibold mb-3">
                    Detail Pengiriman & Gudang
                </h5>

                <div class="mb-3">
                    <small class="text-muted">Gudang Tujuan</small>
                    <div class="fw-semibold fs-6">Gudang Utama</div>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Alamat Gudang</small>
                    <div class="fw-medium">
                        Jl. Raya Industri No. 45<br>
                        Kawasan Pergudangan Solo Raya<br>
                        Surakarta, Jawa Tengah<br>
                        Kode Pos 57152
                    </div>
                </div>

                <hr>

                <div class="row g-3">
                    <div class="col-sm-4">
                        <small class="text-muted">Kode Pesanan</small>
                        <div class="fw-semibold">{{ $order->order_code }}</div>
                    </div>

                    <div class="col-sm-4">
                        <small class="text-muted">Nama Barang</small>
                        <div class="fw-semibold">{{ $order->item_name }}</div>
                    </div>

                    <div class="col-sm-4">
                        <small class="text-muted">Status Pesanan</small>
                        <div class="fw-semibold text-capitalize">
                            {{ $order->status }}
                        </div>
                    </div>
                </div>

            </div>

            {{-- KANAN : QR & ACTION --}}
            <div class="col-md-5 text-center">

                <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode($mapsLink) }}"
                     alt="QR Alamat Gudang"
                     class="img-fluid rounded-3 mb-3">

                <p class="small text-muted mb-3">
                    Scan QR untuk membuka lokasi gudang di Google Maps
                </p>

                <a href="{{ $mapsLink }}"
                   target="_blank"
                   class="btn btn-success d-inline-flex align-items-center gap-2">
                    <i class="fas fa-map-marked-alt"></i>
                    Buka di Google Maps
                </a>

            </div>

        </div>

    </div>
</div>
