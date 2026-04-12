@extends('layouts.main')

@section('title', 'Generate QR Code')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>🔲 Generate QR Code</h4></div>
                <div class="card-body">
                    <form action="{{ route('user.qrcode.generate') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Teks / URL / ID Pesanan</label>
                            <input type="text"
                                   name="text"
                                   class="form-control"
                                   placeholder="Masukkan teks atau URL..."
                                   value="{{ $text ?? '' }}"
                                   required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Generate QR Code
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if(isset($dataUrl))
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Hasil QR Code</h4></div>
                <div class="card-body text-center">
                    <img src="{{ $dataUrl }}" alt="QR Code" class="img-fluid mb-3" style="max-width: 300px;">
                    <br>
                    <a href="{{ $dataUrl }}" download="qrcode.png" class="btn btn-success">
                        ⬇️ Download QR Code
                    </a>
                    <p class="mt-2 text-muted small">Isi: <strong>{{ $text }}</strong></p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection