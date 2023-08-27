<?php

namespace App\Service;

use App\Entity\Image;

class ImageService
{

    private const UPLOAD_PATH = 'uploads/';
    private const IMAGE_PREFIX = 'foodnet_';

    private const URL_PATH = 'https://localhost/api/foodnet/';

    /**
     * @param string $base64Image
     * @return Image
     */
    public function saveImage(string $base64Image): Image
    {
        // Extract the MIME type from the Base64 string
        list(, $base64Data) = explode(';', $base64Image);
        list(, $base64Data) = explode(',', $base64Data);

        // Decode the base64 image data
        $decodedImage = base64_decode($base64Data);

        // Generate a unique filename for the image
        $filename = uniqid(self::IMAGE_PREFIX) . '.' . $this->getImageExtension($base64Image);

        // Specify the path where you want to save the image
        $path = self::UPLOAD_PATH . $filename;

        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        // Save the image to the specified path
        $fileSize = file_put_contents($path, $decodedImage);

        return (new Image())
            ->setName($filename)
            ->setPath(self::URL_PATH . $path)
            ->setFileSize($fileSize)
            ->setUploadedAt(new \DateTime());
    }

    /**
     * @param $dataUri
     * @return string|null
     */
    private function getImageExtension($dataUri): ?string
    {
        $pattern = '/image\/(.*?);/';
        preg_match($pattern, $dataUri, $matches);
        return isset($matches[1]) ? $matches[1] : null;
    }
}