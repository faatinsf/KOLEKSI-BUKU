@extends('layoutsv.main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Pesanan Lunas</h3>
        <small class="text-muted">Menampilkan semua pesanan yang sudah dibayar</small>
    </div>
    <span class="badge bg-success fs-6">{{ $orders->count() }} Pesanan</span>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">

        {{-- Search & Show per page --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <label class="mb-0 text-muted small">Tampilkan</label>
                <select id="perPage" class="form-select form-select-sm" style="width:80px">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="-1">Semua</option>
                </select>
                <label class="mb-0 text-muted small">data</label>
            </div>
            <input type="text" id="searchInput" class="form-control form-control-sm" style="width:220px" placeholder="🔍 Cari...">
        </div>

        <div class="table-responsive">
            <table id="tabelOrder" class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="cursor:pointer" onclick="sortTable(0)">No <span id="sort0">⇅</span></th>
                        <th style="cursor:pointer" onclick="sortTable(1)">Waktu <span id="sort1">⇅</span></th>
                        <th style="cursor:pointer" onclick="sortTable(2)">Customer <span id="sort2">⇅</span></th>
                        <th>Item</th>
                        <th style="cursor:pointer" onclick="sortTable(4)">Total <span id="sort4">⇅</span></th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($orders as $i => $order)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $order->guestUser->nama_guest }}</td>
                        <td>
                            @php
                                $items = $order->orderDetails->map(fn($d) => $d->menu->nama_menu . ' x' . $d->jumlah)->implode(', ');
                            @endphp
                            {{ $items }}
                        </td>
                        <td data-value="{{ $order->total }}">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td><span class="badge bg-success">Lunas</span></td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="6" class="text-center text-muted py-4">Belum ada pesanan lunas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination info + buttons --}}
        <div class="d-flex justify-content-between align-items-center mt-2">
            <div id="infoText" class="text-muted small"></div>
            <div id="pagination" class="d-flex gap-1"></div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
    const tbody     = document.getElementById('tableBody');
    const searchEl  = document.getElementById('searchInput');
    const perPageEl = document.getElementById('perPage');
    const infoEl    = document.getElementById('infoText');
    const pagEl     = document.getElementById('pagination');

    let allRows     = Array.from(tbody.querySelectorAll('tr')).filter(r => !r.id);
    let filtered    = [...allRows];
    let currentPage = 1;
    let sortCol     = 1;
    let sortAsc     = false;

    // Sort default: kolom Waktu desc
    doSort(1, false);

    function render() {
        const per  = parseInt(perPageEl.value);
        const total = filtered.length;
        const pages = per === -1 ? 1 : Math.ceil(total / per);
        if (currentPage > pages) currentPage = 1;

        const start = per === -1 ? 0 : (currentPage - 1) * per;
        const end   = per === -1 ? total : Math.min(start + per, total);

        // Hide all, show filtered slice
        allRows.forEach(r => r.style.display = 'none');
        filtered.slice(start, end).forEach(r => r.style.display = '');

        // Info
        infoEl.textContent = total === 0
            ? 'Tidak ada data'
            : `Menampilkan ${start + 1}–${end} dari ${total} data`;

        // Pagination
        pagEl.innerHTML = '';
        if (pages > 1) {
            makeBtn('‹', currentPage === 1, () => { currentPage--; render(); });
            for (let p = 1; p <= pages; p++) {
                const btn = document.createElement('button');
                btn.className = 'btn btn-sm ' + (p === currentPage ? 'btn-primary' : 'btn-outline-secondary');
                btn.textContent = p;
                btn.onclick = () => { currentPage = p; render(); };
                pagEl.appendChild(btn);
            }
            makeBtn('›', currentPage === pages, () => { currentPage++; render(); });
        }
    }

    function makeBtn(label, disabled, fn) {
        const btn = document.createElement('button');
        btn.className = 'btn btn-sm btn-outline-secondary';
        btn.textContent = label;
        btn.disabled = disabled;
        btn.onclick = fn;
        pagEl.appendChild(btn);
    }

    function doSearch() {
        const q = searchEl.value.toLowerCase();
        filtered = allRows.filter(r => r.textContent.toLowerCase().includes(q));
        currentPage = 1;
        render();
    }

    function doSort(col, asc) {
        sortCol = col;
        sortAsc = asc;
        // Reset icons
        document.querySelectorAll('[id^="sort"]').forEach(el => el.textContent = '⇅');
        const icon = document.getElementById('sort' + col);
        if (icon) icon.textContent = asc ? '▲' : '▼';

        filtered.sort((a, b) => {
            const aEl = a.querySelectorAll('td')[col];
            const bEl = b.querySelectorAll('td')[col];
            const aVal = (aEl?.dataset.value ?? aEl?.textContent ?? '').trim();
            const bVal = (bEl?.dataset.value ?? bEl?.textContent ?? '').trim();
            const aNum = parseFloat(aVal);
            const bNum = parseFloat(bVal);
            const cmp  = !isNaN(aNum) && !isNaN(bNum)
                ? aNum - bNum
                : aVal.localeCompare(bVal, 'id');
            return asc ? cmp : -cmp;
        });
        render();
    }

    // Expose sort untuk onclick di thead
    window.sortTable = function (col) {
        doSort(col, sortCol === col ? !sortAsc : true);
    };

    searchEl.addEventListener('input', doSearch);
    perPageEl.addEventListener('change', () => { currentPage = 1; render(); });

    // Init
    render();
})();
</script>
@endsection