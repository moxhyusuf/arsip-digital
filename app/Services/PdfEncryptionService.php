<?php

namespace App\Services;

use setasign\Fpdi\Tcpdf\Fpdi;

class PdfEncryptionService
{
    public function encrypt(string $absolutePath, string $passphrase): bool
    {
        try {
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($absolutePath);

            for ($i = 1; $i <= $pageCount; $i++) {
                $templateId = $pdf->importPage($i);
                $size = $pdf->getTemplateSize($templateId);

                $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
                $pdf->AddPage($orientation, [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);
            }

            $pdf->SetProtection(
                ['print', 'copy', 'modify'], // permission yg di-block
                $passphrase,                  // user password (wajib utk buka)
                bin2hex(random_bytes(8)),     // owner password (acak, full access)
                0,
                null,
                'AES-256'
            );

            $tmpOutput = $absolutePath . '.tmp';
            $pdf->Output($tmpOutput, 'F');

            rename($tmpOutput, $absolutePath);
            return true;
        } catch (\Exception $e) {
            \Log::error('PDF Encrypt Error: ' . $e->getMessage());
            return false;
        }
    }
}
