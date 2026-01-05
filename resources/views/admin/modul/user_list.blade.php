@php
use App\Models\User;

$user = User::where('role', 'user')
    ->orderBy('company_name', 'asc')
    ->get();
@endphp

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div class="w-100">
        <h4 class="fw-semibold mb-1">list pengguna</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-10 small">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin', 'dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    list pengguna
                </li>
            </ol>
        </nav>
    </div>

    {{-- SEARCH --}}
    <div class="w-100 d-flex justify-content-md-end">
        <div class="input-group input-group-sm shadow-sm rounded-pill overflow-hidden w-100"
            style="max-width: 360px;">
            <span class="input-group-text bg-white border-0 ps-3">
                <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text"
                id="orderSearch"
                class="form-control border-0 pe-3"
                placeholder="Cari pengguna...">
        </div>
    </div>

</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode Pengguna</th>
                        <th>Perusahaan</th>
                        <th>Nama Perwakilan</th>
                        <th>Nomer Telephone</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="userTable">
                    @forelse ($user as $user)
                    <tr class="user-row text-center">

                        <td>{{ $loop->iteration }}</td>

                        {{-- Kode User --}}
                        <td class="fw-medium">{{ $user->user_code }}</td>

                        {{-- Perusahaan --}}
                        <td>{{ $user->company_name ?? '-' }}</td>

                        {{-- Nama --}}
                        <td>{{ $user->name }}</td>

                        {{-- Telepon --}}
                        <td>{{ $user->phone ?? '-' }}</td>

                        {{-- Dibuat --}}
                        <td>{{ $user->created_at->format('d M Y') }}</td>

                        {{-- Aksi --}}
                        <td>
                            <div class="btn-group btn-group-sm gap-1" role="group">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->phone) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-success d-flex align-items-center gap-1">
                                    <i class="fab fa-whatsapp"></i>
                                    <span class="d-none d-md-inline">Hubungi Pengguna</span>
                                </a>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            Belum ada data pengguna
                        </td>
                    </tr>
                    @endforelse

                    <tr id="noResultRow" style="display:none;">
                        <td colspan="9" class="text-center text-muted py-4">
                            Data yang dicari tidak tersedia
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

    </div>
</div>
<script>
const searchInput = document.getElementById('orderSearch');
const rows = document.querySelectorAll('#userTable .user-row');
const noResultRow = document.getElementById('noResultRow');

searchInput.addEventListener('input', function () {
    const keyword = this.value.toLowerCase().trim();
    let found = false;

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const match = keyword === '' || text.includes(keyword);

        row.style.display = match ? '' : 'none';
        if (match && keyword !== '') found = true;
    });

    noResultRow.style.display = (keyword !== '' && !found) ? '' : 'none';
});
</script>

