<!DOCTYPE html>
<html>
<head>
    <title>Undangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .content {
            line-height: 1.8;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>FAKULTAS VOKASI</h2>
        <p>Universitas Airlangga</p>
    </div>

    <div class="content">
        <p>Nomor : 001/FVV/UND/I/2026</p>
        <p>Perihal : Undangan</p>

        <br>

        <p>Kepada Yth:</p>
        <p><b>{{ $user->name }}</b></p>

        <br>

        <p>
            Dengan hormat,  
            kami mengundang Saudara/i untuk menghadiri kegiatan
            akademik yang akan diselenggarakan oleh Fakultas.
        </p>

        <br>

        <p>Demikian undangan ini disampaikan.</p>

        <br><br>
        <p>{{ date('d F Y') }}</p>
    </div>

</body>
</html>
