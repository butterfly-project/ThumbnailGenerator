<?php

namespace Butterfly\Component\ThumbnailGenerator;

class ThumbnailTwigExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('thumbnail', [$this, 'getThumbnailUrl']),
        ];
    }

    /**
     * @param string $filename
     * @param string $size
     * @return string
     */
    public function getThumbnailUrl($filename, $size)
    {
        $raw1 = explode('.', $filename);

        if (2 > count($raw1)) {
            return $filename . '_' . $size;
        }

        $originalExtension = array_pop($raw1);
        $basename          = mb_substr($filename, 0, -1 * (mb_strlen($originalExtension) + 1));

        return $basename . '_' . $size . '.' . $originalExtension;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'data.thumbnail';
    }
}
