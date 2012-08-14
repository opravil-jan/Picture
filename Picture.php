<?php

/**
 * Description of Picture
 *
 * @author machar
 */
namespace Picture;

class Picture extends \Nette\Object {
    
    protected $idPicture;
    protected $width;
    protected $height;
    protected $source;
    protected $mimeType;
    protected $extension;
    protected $createDate;
    
    public function getIdPicture() {
        return $this->idPicture;
    }

    public function setIdPicture($idPicture) {
        $this->idPicture = $idPicture;
    }

    public function getWidth() {
        return $this->width;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
    }

    public function getMimeType() {
        return $this->mimeType;
    }

    public function setMimeType($mimeType) {
        $this->mimeType = $mimeType;
    }
    
    public function getExtension() {
        $extension = null;
        switch ($this->mimeType) {
            case "image/jpeg":
                $extension = "jpg";
                break;
            case "image/png":
                $extension = "png";
                break;
        }
        return $extension;
    }
    
    public function getCreateDate() {
        return $this->createDate;
    }

    public function setCreateDate($createDate) {
        $this->createDate = $createDate;
    }


}

?>
