<?php

namespace App\Http\Controllers;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function index()
    {
        return view('user.qrcode.index');
    }

    public function generate(Request $request)
    {
        $text = $request->input('text', 'https://example.com');

        $writer = new PngWriter();

        $qrCode = QrCode::create($text)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
            ->setSize(300)
            ->setMargin(10)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        $result = $writer->write($qrCode);

        $base64  = base64_encode($result->getString());
        $dataUrl = 'data:image/png;base64,' . $base64;

        return view('user.qrcode.index', compact('dataUrl', 'text'));
    }
}