<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow mx-auto" style="max-width:520px">
        <div class="card-body text-center p-5">
            <div class="display-3 mb-3">✅</div>
            <h3 class="fw-bold text-success">Pesanan Diterima!</h3>
            <p class="text-muted mb-1">Halo, <strong>{{ $order->guestUser->nama_guest }}</strong></p>
            <p class="text-muted">Pesananmu di <strong>{{ $order->vendor->nama_vendor }}</strong> sedang diproses.</p>

            <div class="card bg-light mt-3 text-start">
                <div class="card-body">
                    <h6 class="fw-semibold mb-2">Detail Pesanan #{{ $order->id }}</h6>
                    @foreach($order->orderDetails as $detail)
                        <div class="d-flex justify-content-between">
                            <span>{{ $detail->menu->nama_menu }} ×{{ $detail->jumlah }}</span>
                            <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span class="text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="mt-2">
                        <span class="badge {{ $order->status_pembayaran === 'lunas' ? 'bg-success' : 'bg-warning text-dark' }} fs-6">
                            {{ strtoupper($order->status_pembayaran) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- QR CODE --}}
            <div class="mt-4">
                <p class="text-muted small mb-2">Tunjukkan QR Code ini ke kasir untuk konfirmasi pesanan</p>
                <img src="{{ $qrImage }}" alt="QR Code Pesanan" style="width:200px;height:200px;">
                <p class="text-muted small mt-2">ID Pesanan: <strong>#{{ $order->id }}</strong></p>
            </div>

            <a href="{{ route('kantin.order') }}" class="btn btn-primary mt-4 w-100">
                Pesan Lagi
            </a>
        </div>
    </div>
</div>
</body>
</html>