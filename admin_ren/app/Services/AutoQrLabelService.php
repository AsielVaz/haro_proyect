<?php

namespace App\Services;

use App\Models\Auto;
use RuntimeException;

class AutoQrLabelService
{
    private const PUBLIC_SITE = 'https://seminuevosharo.mx';

    public function generate(Auto $auto): string
    {
        if (! function_exists('imagecreatetruecolor')) {
            throw new RuntimeException('La extensión GD de PHP no está disponible.');
        }

        $auto->loadMissing(['marca:id,marca,imagen', 'modelo:id,modelo']);
        $this->loadQrLibrary();
        $qr = $this->makeQr(self::PUBLIC_SITE.'/vehicle-details.php?auto='.$auto->id);

        $canvas = imagecreatetruecolor(500, 300);
        $white = imagecolorallocate($canvas, 255, 255, 255);
        $black = imagecolorallocate($canvas, 30, 30, 30);
        $gray = imagecolorallocate($canvas, 110, 110, 110);
        imagefill($canvas, 0, 0, $white);

        $this->placeImage($canvas, $qr, 10, 10, 280, 280, $white);
        imagedestroy($qr);

        $logoBottom = 20;
        $logo = $this->readImage('/assets/media/general/logo_bn.png');
        if ($logo) {
            [$logoWidth, $logoHeight] = $this->fit(imagesx($logo), imagesy($logo), 230, 143);
            $this->placeImage($canvas, $logo, 500 - $logoWidth, 10, $logoWidth, $logoHeight, $white);
            $logoBottom = 20 + $logoHeight;
            imagedestroy($logo);
        }

        $rightX = 260;
        $rightWidth = 230;
        $textStart = $logoBottom + 12;
        $lineHeight = max(20, (int) ((300 - $textStart - 10) / 3));
        $brand = $this->readBrandImage((string) ($auto->marca?->imagen ?? ''));

        if ($brand) {
            [$brandWidth, $brandHeight] = $this->fit(imagesx($brand), imagesy($brand), $rightWidth - 24, (int) ($lineHeight * 1.6));
            $this->placeImage($canvas, $brand, $rightX + (int) (($rightWidth - $brandWidth) / 2), $textStart + (int) (($lineHeight - $brandHeight) / 2), $brandWidth, $brandHeight, $white);
            imagedestroy($brand);
        } else {
            $this->drawCenteredText($canvas, (string) ($auto->marca?->marca ?? ''), $rightX, $rightWidth, $textStart, $lineHeight, $black, 25);
        }

        $this->drawCenteredText($canvas, (string) ($auto->modelo?->modelo ?? ''), $rightX, $rightWidth, $textStart + $lineHeight, $lineHeight, $black, 30);
        $this->drawCenteredText($canvas, (string) $auto->anio, $rightX, $rightWidth, $textStart + ($lineHeight * 2), $lineHeight, $gray, 28);

        ob_start();
        imagepng($canvas);
        $png = (string) ob_get_clean();
        imagedestroy($canvas);

        if ($png === '') {
            throw new RuntimeException('No se pudo componer la etiqueta QR.');
        }

        return $png;
    }

    private function loadQrLibrary(): void
    {
        if (class_exists('QRcode')) {
            return;
        }

        $library = dirname(base_path()).DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'banca'.DIRECTORY_SEPARATOR.'api'.DIRECTORY_SEPARATOR.'phpqrcode'.DIRECTORY_SEPARATOR.'qrlib.php';
        if (! is_file($library)) {
            throw new RuntimeException('No se encontró la librería para generar códigos QR.');
        }

        require_once $library;
    }

    private function makeQr(string $url): \GdImage
    {
        $previousErrorLevel = error_reporting();
        error_reporting($previousErrorLevel & ~E_DEPRECATED);
        ob_start();
        try {
            \QRcode::png($url, false, QR_ECLEVEL_M, 8, 2);
            $raw = (string) ob_get_clean();
        } finally {
            error_reporting($previousErrorLevel);
        }
        $image = imagecreatefromstring($raw);

        if (! $image) {
            throw new RuntimeException('No se pudo generar el patrón QR.');
        }

        return $image;
    }

    private function readBrandImage(string $source): \GdImage|false
    {
        if ($source === '') {
            return false;
        }

        $darkSource = preg_replace('/(\.[^.\/]+)$/', '_b$1', $source) ?: $source;

        return $this->readImage($darkSource) ?: $this->readImage($source);
    }

    private function readImage(string $source): \GdImage|false
    {
        $path = (string) parse_url($source, PHP_URL_PATH);
        $local = dirname(base_path()).DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, ltrim($path, '/'));
        $raw = is_file($local) ? file_get_contents($local) : @file_get_contents(str_starts_with($source, 'http') ? $source : self::PUBLIC_SITE.'/'.ltrim($source, '/'));

        return $raw ? (@imagecreatefromstring($raw) ?: false) : false;
    }

    private function fit(int $sourceWidth, int $sourceHeight, int $maxWidth, int $maxHeight): array
    {
        $scale = min($maxWidth / $sourceWidth, $maxHeight / $sourceHeight);

        return [max(1, (int) ($sourceWidth * $scale)), max(1, (int) ($sourceHeight * $scale))];
    }

    private function placeImage(\GdImage $canvas, \GdImage $source, int $x, int $y, int $width, int $height, int $background): void
    {
        $resized = imagecreatetruecolor($width, $height);
        imagefill($resized, 0, 0, $background);
        imagealphablending($resized, true);
        imagecopyresampled($resized, $source, 0, 0, 0, 0, $width, $height, imagesx($source), imagesy($source));
        imagecopy($canvas, $resized, $x, $y, 0, 0, $width, $height);
        imagedestroy($resized);
    }

    private function drawCenteredText(\GdImage $canvas, string $text, int $x, int $width, int $top, int $height, int $color, int $maxSize): void
    {
        if ($text === '') {
            return;
        }

        $font = $this->fontPath();
        if ($font && function_exists('imagettftext')) {
            $size = $maxSize;
            do {
                $box = imagettfbbox($size, 0, $font, $text);
                $textWidth = abs($box[4] - $box[0]);
                $textHeight = abs($box[5] - $box[1]);
                $size--;
            } while ($textWidth > $width - 24 && $size >= 8);
            $baseline = $top + (int) (($height + $textHeight) / 2);
            imagettftext($canvas, $size + 1, 0, $x + (int) (($width - $textWidth) / 2), $baseline, $color, $font, $text);

            return;
        }

        $textWidth = strlen($text) * imagefontwidth(5);
        imagestring($canvas, 5, $x + (int) (($width - $textWidth) / 2), $top + (int) (($height - imagefontheight(5)) / 2), $text, $color);
    }

    private function fontPath(): ?string
    {
        foreach (['C:\\Windows\\Fonts\\arialbd.ttf', '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf', '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf'] as $font) {
            if (is_file($font)) {
                return $font;
            }
        }

        return null;
    }
}
