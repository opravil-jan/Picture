<?php

/**
 * Description of Picture
 *
 * @author machar
 */

namespace Picture;

class ServicePicture extends \Nette\Object implements IPicture {

    /**
     *
     * @var mapper MapperPicture
     */
    protected $mapper;

    public function __construct(MapperPicture $mapper) {
        $this->mapper = $mapper;
    }

    /**
     *
     * @param string $idPhoto
     * @param integer $width
     * @param integer $height
     * @return object Picture
     */
    public function get($idPhoto, $width = null, $height = null) {
        return $this->mapper->get(new \MongoId($idPhoto), $width, $height);
    }

    /**
     *
     * @param type $haystack
     * @param type $needle
     * @return array \MongoId 
     */
    public function find($haystack, $needle) {
        return $this->mapper->find($haystack, $needle);
    }

    /**
     *
     * @param Picture $picture
     * @param \Nette\ArrayHash $options - pro ulozeni dalsich parametru fotky ve formatu klic/hodnota
     */
    public function save(Picture $picture, \Nette\ArrayHash $options = null) {
        $this->mapper->save($picture, $options);
    }

    /**
     *
     * @param Picture $picture 
     */
    public function delete(Picture $picture) {
        $this->mapper->delete(new MongoId($picture->getIdPicture()));
    }

    /**
     *
     * @param Picture $picture 
     */
    public function update(Picture $picture) {
        $this->mapper->update(new MongoId($picture->getIdPicture()));
    }

}

?>
