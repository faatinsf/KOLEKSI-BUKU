@extends('layoutsv.main')

@section('content')
<div class="row">
    <div class="col-12">
        <h3 class="fw-bold mb-4">Dashboard Vendor</h3>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                    <i class="mdi mdi-silverware-fork-knife text-primary" style="font-size:2rem"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Menu</div>
                    <div class="fs-3 fw-bold">
                        {{ auth()->user()->vendor?->menus()->count() ?? 0 }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="bg-success bg-opacity-10 rounded-3 p-3">
                    <i class="mdi mdi-check-circle text-success" style="font-size:2rem"></i>
                </div>
                <div>
                    <div class="text-muted small">Pesanan Lunas</div>
                    <div class="fs-3 fw-bold">
                        {{ auth()->user()->vendor?->orders()->where('status_pembayaran','lunas')->count() ?? 0 }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-semibold mb-3">Pintasan</h5>
                <a href="{{ route('vendor.menu.index') }}" class="btn btn-outline-primary me-2">
                    <i class="mdi mdi-food"></i> Kelola Menu
                </a>
                <a href="{{ route('vendor.orders.index') }}" class="btn btn-outline-success">
                    <i class="mdi mdi-clipboard-list"></i> Lihat Pesanan Lunas
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
