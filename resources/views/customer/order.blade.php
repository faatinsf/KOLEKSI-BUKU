<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pesan Kantin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f5f6fa; }
        .card-menu {
            cursor: pointer;
            transition: all .2s;
            border: 2px solid transparent;
        }
        .card-menu:hover { border-color: #0d6efd; transform: translateY(-2px); }
        .card-menu.selected { border-color: #0d6efd; background: #e8f0fe; }
        .badge-qty {
            font-size: 1rem;
            min-width: 28px;
            text-align: center;
        }
        #cart-section { position: sticky; top: 20px; }
    </style>
</head>
<body>
<div class="container py-4">
    <h3 class="fw-bold mb-1">🍽️ Kantin Online</h3>
    <p class="text-muted mb-4">Pesan makanan favoritmu, bayar langsung!</p>

    <div class="row">
        {{-- Kiri: Pilih Vendor & Menu --}}
        <div class="col-md-8">
            {{-- Step 1: Pilih Vendor --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">1. Pilih Vendor</h5>
                    <select id="selectVendor" class="form-select form-select-lg">
                        <option value="">-- Pilih Vendor --</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->nama_vendor }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Step 2: Daftar Menu --}}
            <div class="card shadow-sm mb-4" id="menuSection" style="display:none">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">2. Pilih Menu</h5>
                    <div id="menuList" class="row g-3">
                        {{-- Diisi oleh AJAX --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- Kanan: Keranjang --}}
        <div class="col-md-4">
            <div id="cart-section" class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">🛒 Pesananmu</h5>
                    <div id="cartItems">
                        <p class="text-muted text-center">Belum ada menu dipilih</p>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span id="totalHarga">Rp 0</span>
                    </div>
                    <button id="btnCheckout" class="btn btn-primary w-100 mt-3" disabled>
                        Bayar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
let cart   = {};  // { menu_id: { nama, harga, jumlah } }
let vendorId = null;

// ======================
// 1. Pilih vendor → load menu via AJAX
// ======================
$('#selectVendor').on('change', function () {
    vendorId = $(this).val();
    cart     = {};
    renderCart();

    if (!vendorId) {
        $('#menuSection').hide();
        return;
    }

    $.get(`/kantin/menu/${vendorId}`, function (menus) {
        let html = '';
        if (menus.length === 0) {
            html = '<p class="text-muted">Vendor ini belum punya menu.</p>';
        } else {
            menus.forEach(m => {
                html += `
                <div class="col-6 col-lg-4">
                    <div class="card card-menu h-100" data-id="${m.id}" data-nama="${m.nama_menu}" data-harga="${m.harga}">
                        <div class="card-body text-center p-3">
                            <div class="fs-2 mb-1">🍱</div>
                            <div class="fw-semibold">${m.nama_menu}</div>
                            <div class="text-primary fw-bold">Rp ${m.harga.toLocaleString('id-ID')}</div>
                            <div class="mt-2 d-flex align-items-center justify-content-center gap-2">
                                <button class="btn btn-sm btn-outline-secondary btn-minus" data-id="${m.id}">−</button>
                                <span class="badge-qty" id="qty-${m.id}">0</span>
                                <button class="btn btn-sm btn-outline-primary btn-plus" data-id="${m.id}">+</button>
                            </div>
                        </div>
                    </div>
                </div>`;
            });
        }
        $('#menuList').html(html);
        $('#menuSection').show();
    });
});

// ======================
// 2. Tombol + dan -
// ======================
$(document).on('click', '.btn-plus', function () {
    const card  = $(this).closest('.card-menu');
    const id    = card.data('id');
    const nama  = card.data('nama');
    const harga = card.data('harga');

    if (!cart[id]) cart[id] = { nama, harga, jumlah: 0 };
    cart[id].jumlah++;

    $(`#qty-${id}`).text(cart[id].jumlah);
    card.addClass('selected');
    renderCart();
});

$(document).on('click', '.btn-minus', function () {
    const id = $(this).closest('.card-menu').data('id');
    if (!cart[id] || cart[id].jumlah === 0) return;

    cart[id].jumlah--;
    $(`#qty-${id}`).text(cart[id].jumlah);

    if (cart[id].jumlah === 0) {
        delete cart[id];
        $(this).closest('.card-menu').removeClass('selected');
    }
    renderCart();
});

// ======================
// 3. Render keranjang
// ======================
function renderCart() {
    const ids = Object.keys(cart);
    if (ids.length === 0) {
        $('#cartItems').html('<p class="text-muted text-center">Belum ada menu dipilih</p>');
        $('#totalHarga').text('Rp 0');
        $('#btnCheckout').prop('disabled', true);
        return;
    }

    let html  = '';
    let total = 0;

    ids.forEach(id => {
        const item = cart[id];
        const sub  = item.harga * item.jumlah;
        total += sub;
        html += `
        <div class="d-flex justify-content-between mb-1">
            <span>${item.nama} ×${item.jumlah}</span>
            <span class="text-primary">Rp ${sub.toLocaleString('id-ID')}</span>
        </div>`;
    });

    $('#cartItems').html(html);
    $('#totalHarga').text('Rp ' + total.toLocaleString('id-ID'));
    $('#btnCheckout').prop('disabled', false);
}

// ======================
// 4. Checkout → Midtrans Snap
// ======================
$('#btnCheckout').on('click', function () {
    const items = Object.keys(cart).map(id => ({
        menu_id: parseInt(id),
        jumlah : cart[id].jumlah,
    }));

    $(this).prop('disabled', true).text('Memproses...');

    $.ajax({
        url    : '/kantin/checkout',
        method : 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        contentType: 'application/json',
        data   : JSON.stringify({ vendor_id: vendorId, items }),
        success: function (res) {
            snap.pay(res.snap_token, {
                onSuccess: function (result) {
                    window.location.href = `/kantin/sukses/${res.order_id}`;
                },
                onPending: function (result) {
                    alert('Pembayaran pending. Selesaikan pembayaranmu ya!');
                    window.location.href = `/kantin/sukses/${res.order_id}`;
                },
                onError: function (result) {
                    alert('Pembayaran gagal. Silakan coba lagi.');
                    $('#btnCheckout').prop('disabled', false).text('Bayar Sekarang');
                },
                onClose: function () {
                    $('#btnCheckout').prop('disabled', false).text('Bayar Sekarang');
                }
            });
        },
        error: function (xhr) {
            alert('Terjadi kesalahan: ' + (xhr.responseJSON?.error ?? 'Unknown error'));
            $('#btnCheckout').prop('disabled', false).text('Bayar Sekarang');
        }
    });
});
</script>
</body>
</html>
