@extends('layouts.main')

@section('title', 'Tambah Customer - Foto File')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h4>📸 Tambah Customer (Foto disimpan sebagai File)</h4></div>
        <div class="card-body">

            <div class="mb-3 text-center">
                <video id="video" width="320" height="240"
                       style="border:2px solid #ccc;border-radius:8px;display:none;"
                       autoplay></video>
                <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
                <div id="preview-container" style="display:none;">
                    <img id="foto-preview" width="320" height="240"
                         style="border:2px solid #28a745;border-radius:8px;">
                </div>
            </div>

            <div class="mb-3 text-center">
                <button type="button" id="btn-kamera" class="btn btn-info">📷 Buka Kamera</button>
                <button type="button" id="btn-foto"   class="btn btn-warning" style="display:none;">📸 Ambil Foto</button>
                <button type="button" id="btn-ulang"  class="btn btn-secondary" style="display:none;">🔄 Ulangi</button>
            </div>

            <form action="{{ route('user.customer.simpan2') }}" method="POST">
                @csrf
                <input type="hidden" name="foto" id="foto_file">

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telepon" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary" id="btn-simpan" disabled>
                    💾 Simpan Customer
                </button>
                <a href="{{ route('user.customer.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<script>
let stream = null;
const video     = document.getElementById('video');
const canvas    = document.getElementById('canvas');
const preview   = document.getElementById('foto-preview');
const previewC  = document.getElementById('preview-container');
const fotoInput = document.getElementById('foto_file');
const btnSimpan = document.getElementById('btn-simpan');

document.getElementById('btn-kamera').addEventListener('click', async () => {
    try {
        stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;
        video.style.display = 'block';
        document.getElementById('btn-kamera').style.display = 'none';
        document.getElementById('btn-foto').style.display   = 'inline-block';
    } catch (err) {
        alert('Tidak bisa mengakses kamera: ' + err.message);
    }
});

document.getElementById('btn-foto').addEventListener('click', () => {
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, 320, 240);
    const dataUrl = canvas.toDataURL('image/jpeg');

    preview.src = dataUrl;
    previewC.style.display = 'block';
    video.style.display = 'none';

    if (stream) stream.getTracks().forEach(t => t.stop());

    fotoInput.value = dataUrl;
    btnSimpan.disabled = false;

    document.getElementById('btn-foto').style.display  = 'none';
    document.getElementById('btn-ulang').style.display = 'inline-block';
});

document.getElementById('btn-ulang').addEventListener('click', () => {
    preview.src = '';
    previewC.style.display = 'none';
    fotoInput.value = '';
    btnSimpan.disabled = true;
    document.getElementById('btn-ulang').style.display  = 'none';
    document.getElementById('btn-kamera').style.display = 'inline-block';
    document.getElementById('btn-foto').style.display   = 'none';
});
</script>
@endsection