<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Photo extends Controller {

    private $image;

    public function postPrintPhoto(Request $req){
        if($req->hasFile('photo')){
            $this->process();
            imagedestroy($this->image);
            return response()->json(["error"=>0]);
        } else {
            return response()->json(["error"=>1]);
        }
    }

    private function process(){
        $this->startImage();
        $this->pasteFrame();
        $this->pasteUserImage();
        $this->saveNprint();
    }

    private function pasteFrame(){
        $frame = imagecreatefrompng(getcwd()."../../public/img/frame.png");
        imagecopy($this->image, $frame, 0, 0, 0, 0, 1052, 744);
        imagedestroy($frame);
    }

    private function pasteUserImage(){
        $r_factor = 0.6;
        $offsetx = -2;
        $offsety = 32;
        if($r_factor != 1)
        $frame = $this->loadResizedUser($r_factor);
        else
        $frame = imagecreatefrompng($_FILES["photo"]["tmp_name"]);
        imagecopy($this->image, $frame, ((1052 - imagesx($frame)) / 2)+$offsetx, ((744 - imagesy($frame)) / 2)+$offsety, 0, 0, imagesx($frame), imagesy($frame));
        imagedestroy($frame);
    }

    private function loadResizedUser($factor){
        $frame = imagecreatefrompng($_FILES["photo"]["tmp_name"]);
        $size = getimagesize($_FILES["photo"]["tmp_name"]);
        $newWidth = $size[0]*$factor;
        $newHeight = $size[1]*$factor;
        $newFrame = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($newFrame, $frame, 0, 0, 0, 0, $newWidth, $newHeight, $size[0], $size[1]);
        imagedestroy($frame);
        return $newFrame;
    }

    private function startImage(){
        $this->image = imagecreatetruecolor(1052, 744);
        imagefill($this->image, 0, 0, imagecolorallocate($this->image, 255, 255, 255));
    }

    private function saveNprint(){
        $image = "/tmp/" . uniqid() . ".png";
        imagepng($this->image, $image);
        system("lpr " . $image);
    }
}
