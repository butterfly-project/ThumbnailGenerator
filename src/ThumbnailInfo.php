<?php

namespace Butterfly\Component\ThumbnailGenerator;

use Symfony\Component\HttpFoundation\File\File;

class ThumbnailInfo
{
    /**
     * @var File
     */
    protected $originalFile;

    /**
     * @var string
     */
    protected $thumbnailFilepath;

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @param File $originalFile
     * @param string $thumbnailFilepath
     * @param int $width
     * @param int $height
     */
    public function __construct(File $originalFile, $thumbnailFilepath, $width, $height)
    {
        $this->originalFile      = $originalFile;
        $this->thumbnailFilepath = $thumbnailFilepath;
        $this->width             = $width;
        $this->height            = $height;
    }

    /**
     * @return File
     */
    public function getOriginalFile()
    {
        return $this->originalFile;
    }

    /**
     * @return string
     */
    public function getThumbnailFilepath()
    {
        return $this->thumbnailFilepath;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }
}
