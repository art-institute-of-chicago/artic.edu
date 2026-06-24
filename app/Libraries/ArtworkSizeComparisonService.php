<?php

namespace App\Libraries;

class ArtworkSizeComparisonService
{
    // The height the silhouette image represents, in centimeters
    private const PERSON_HEIGHT_CM = 162;

    private const SILHOUETTE_PATH = 'person-silhouette.jpg';

    private const PADDING_PX = 40;
    private const GAP_PX = 60;

    private const RECT_FILL = [0, 0, 0];

    /**
     * Render a JPEG comparing a human silhouette to a rectangle of the given
     * size, both drawn to the same scale. Returns the raw JPEG binary data.
     */
    public function generate(float $artworkWidthCm, float $artworkHeightCm): string
    {
        $silhouette = imagecreatefromjpeg(resource_path('images/' . self::SILHOUETTE_PATH));
        $silhouetteWidth = imagesx($silhouette);
        $silhouetteHeight = imagesy($silhouette);

        $pxPerCm = $silhouetteHeight / self::PERSON_HEIGHT_CM;
        $artworkRectWidth = (int) round($artworkWidthCm * $pxPerCm);
        $artworkRectHeight = (int) round($artworkHeightCm * $pxPerCm);

        $canvasWidth = self::PADDING_PX * 2 + $silhouetteWidth + self::GAP_PX + $artworkRectWidth;
        $canvasHeight = self::PADDING_PX * 2 + max($silhouetteHeight, $artworkRectHeight);
        $ceilingY = self::PADDING_PX;

        $canvas = imagecreatetruecolor($canvasWidth, $canvasHeight);
        imagefill($canvas, 0, 0, imagecolorallocate($canvas, 255, 255, 255));

        $silhouetteX = self::PADDING_PX;
        $silhouetteY = $artworkRectHeight < $silhouetteHeight ? self::PADDING_PX : $canvasHeight - self::PADDING_PX - $silhouetteHeight;
        imagecopy($canvas, $silhouette, $silhouetteX, $silhouetteY, 0, 0, $silhouetteWidth, $silhouetteHeight);
        imagedestroy($silhouette);

        $rectX = $silhouetteX + $silhouetteWidth + self::GAP_PX;
        imagefilledrectangle($canvas, $rectX, $ceilingY, $rectX + $artworkRectWidth, $ceilingY + $artworkRectHeight, imagecolorallocate($canvas, ...self::RECT_FILL));

        ob_start();
        imagejpeg($canvas, null, 90);
        $content = ob_get_clean();
        imagedestroy($canvas);

        return $content;
    }
}
