<?php
namespace App\Libraries\Image;

class ImageJpeg implements Image
{
    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function draw()
    {
        return imagecreatefromjpeg($this->path);
    }
}
