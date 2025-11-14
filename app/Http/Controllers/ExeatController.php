<?php

namespace App\Http\Controllers;

use App\Models\ExeatRequest;
use Endroid\QrCode\Builder\BuilderInterface;

class ExeatController extends Controller
{
    // The BuilderInterface is a service provided by the new package.
    // We can type-hint it here, and Laravel's service container will automatically provide it for us.
    protected $qrCodeBuilder;

    public function __construct(BuilderInterface $qrCodeBuilder)
    {
        $this->qrCodeBuilder = $qrCodeBuilder;
    }

    public function verify($token)
    {
        $exeat = ExeatRequest::where('token', $token)->with('student.user', 'parent', 'approver')->firstOrFail();

        // Use the injected builder to create the QR code
        $qrCodeResult = $this->qrCodeBuilder
            ->data(route('exeat.verify', $exeat->token))
            ->size(150)
            ->margin(10)
            ->build();

        // Get the QR code as a base64 encoded image string
        $qrCodeDataUri = $qrCodeResult->getDataUri();

        // Pass the exeat data AND the QR code image data to the view
        return view('public.verify-exeat', compact('exeat', 'qrCodeDataUri'));
    }
}