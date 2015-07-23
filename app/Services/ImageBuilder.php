<?php namespace App\Services;

class ImageBuilder {
    private $image;

    public function __construct(){
        $this->image = imagecreatetruecolor(1052, 744);
        imagefill($this->image, 0, 0, imagecolorallocate($this->image, 255, 255, 255));
    }

    public function paste($path, $x, $y, $factor){
        $frame = imagecreatefrompng($path);
        $size = getimagesize($path);
        $newWidth = $size[0]*$factor;
        $newHeight = $size[1]*$factor;
        imagecopyresampled($this->image, $frame, $x, $y, 0, 0, $newWidth, $newHeight, $size[0], $size[1]);
        imagedestroy($frame);
    }

    public function save($path){
        imagepng($this->image, $path);
    }

    public function output(){
        header('Content-Type: image/png');
        imagepng($this->image, NULL);
    }

    public function __destruct(){
        imagedestroy($this->image);
    }
}
?>
