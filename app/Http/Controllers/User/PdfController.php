<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    // A4 LANDSCAPE
    public function sertifikat()
    {
        $user = Auth::user();

        $pdf = Pdf::loadView('user.pdf.sertifikat', compact('user'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('sertifikat-user.pdf');
    }

    // A4 PORTRAIT + HEADER
    public function undangan()
    {
        $user = Auth::user();

        $pdf = Pdf::loadView('user.pdf.undangan', compact('user'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('undangan-user.pdf');
    }
}
