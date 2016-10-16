<?php

namespace Butterfly\Component\ThumbnailGenerator;

use Butterfly\Component\ImageProcessor\ImageProcessor;
use Symfony\Component\HttpFoundation\File\File;

class ThumbnailGenerator
{
    /**
     * @var string
     */
    protected $appUploadDir;

    /**
     * @var string
     */
    protected $webUploadDir;

    /**
     * @var ImageProcessor
     */
    protected $imageProcessor;

    /**
     * @param string $appUploadDir
     * @param string $webUploadDir
     * @param ImageProcessor $imageProcessor
     */
    public function __construct($appUploadDir, $webUploadDir, ImageProcessor $imageProcessor)
    {
        $this->appUploadDir   = $appUploadDir;
        $this->webUploadDir   = $webUploadDir;
        $this->imageProcessor = $imageProcessor;
    }

    /**
     * @param string $directory
     * @param string $filename
     * @return null|File
     */
    public function generate($directory, $filename)
    {
        $thumbnailInfo = $this->urlParse($directory, $filename);

        if (null === $thumbnailInfo) {
            return null;
        }

        return $this->imageProcessor->thumbnail(
            $thumbnailInfo->getOriginalFile(),
            $thumbnailInfo->getThumbnailFilepath(),
            $thumbnailInfo->getWidth(),
            $thumbnailInfo->getHeight()
        );
    }

    /**
     * @param string $directory
     * @param string $filename
     * @return ThumbnailInfo|null
     */
    protected function urlParse($directory, $filename)
    {
        $raw1 = explode('.', $filename);

        if (2 > count($raw1)) {
            return null;
        }

        $originalExtension = array_pop($raw1);
        $basename          = mb_substr($filename, 0, -1 * (mb_strlen($originalExtension) + 1));

        $raw2 = explode('_', $basename);

        if (2 > count($raw2)) {
            return null;
        }

        $sizeInfo         = array_pop($raw2);
        $originalFilename = mb_substr($basename, 0, -1 * (mb_strlen($sizeInfo) + 1));

        $raw3 = explode('x', $sizeInfo);

        if (2 !== count($raw3)) {
            return null;
        }

        list($width, $height) = $raw3;
        $width  = (int)$width;
        $height = (int)$height;

        if (empty($width) || empty($height)) {
            return null;
        }

        $imageDirectory    = $this->appUploadDir . '/' . $directory . '/';
        $originalFilepath  = $imageDirectory . $originalFilename . '.' . $originalExtension;
        $thumbnailFilepath = $imageDirectory . $filename;

        if (!is_readable($originalFilepath)) {
            return null;
        }

        return new ThumbnailInfo(new File($originalFilepath), $thumbnailFilepath, $width, $height);
    }
}
