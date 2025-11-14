<?php

return [
    'writer' => \Endroid\QrCode\Writer\PngWriter::class,
    'writer_options' => [],
    'data' => 'QR Code',
    'encoding' => 'UTF-8',
    'error_correction_level' => \Endroid\QrCode\ErrorCorrectionLevel\Low::class,
    'size' => 300,
    'margin' => 10,
    'round_block_size' => true,
    'validate_result' => false,
];