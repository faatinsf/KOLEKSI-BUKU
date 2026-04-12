@extends('layoutsv.main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Tambah Menu</h3>
    <a href="{{ route('vendor.menu.index') }}" class="btn btn-outline-secondary">
        <i class="mdi mdi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow-sm border-0" style="max-width:540px">
    <div class="card-body p-4">
        <form action="{{ route('vendor.menu.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Menu <span class="text-danger">*</span></label>
                <input type="text" name="nama_menu" class="form-control @error('nama_menu') is-invalid @enderror"
                       value="{{ old('nama_menu') }}" placeholder="cth: Nasi Ayam">
                @error('nama_menu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror"
                       value="{{ old('harga') }}" placeholder="cth: 15000" min="0">
                @error('harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"
                          placeholder="Opsional">{{ old('deskripsi') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="mdi mdi-content-save"></i> Simpan Menu
            </button>
        </form>
    </div>
</div>
@endsection
