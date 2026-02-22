<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            padding: 60px;
        }
        .box {
            border: 5px solid #000;
            padding: 40px;
        }
        h1 { font-size: 40px; }
        h2 { margin-top: 40px; }
    </style>
</head>
<body>
    <div class="box">
        <h1>SERTIFIKAT</h1>
        <p>Diberikan kepada:</p>

        <h2>{{ $user->name }}</h2>

        <p>
            Sebagai pengguna aktif  
            Fakultas Vokasi
        </p>

        <br><br>
        <p>{{ date('d F Y') }}</p>
    </div>
</body>
</html>
    