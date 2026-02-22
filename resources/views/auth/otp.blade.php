<form method="POST" action="/otp">
    @csrf

    <h2>Masukkan OTP</h2>

    <input type="text" name="otp" maxlength="6" required autofocus>

    <button type="submit">Verifikasi</button>

    @error('otp')
        <p>{{ $message }}</p>
    @enderror
</form>
