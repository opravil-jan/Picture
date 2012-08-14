<?php

/**
 * Description of MapperPicture
 *
 * @author machar
 */

namespace Picture;

use Nette\Image;

class MapperPicture extends \Nette\Object {

    /**
     *
     * @var collection / nazev databaze v mongu
     */
    private $collection;

    public function __construct(\Mongo $mongo, $db, $table) {
        $this->collection = $mongo->{$db}->{$table};
    }

    /**
     *
     * @param \MongoId $mongoId
     * @param integer $width
     * @param integer $height
     * @return Picture $picture nebo NULL 
     */
    public function get(\MongoId $mongoId, $width = null, $height = null) {
        $width = (int) $width;
        $height = (int) $height;
        
        $obj = $this->collection->findOne(array("_id" => $mongoId));
        if ($obj) {
            $picture = unserialize($obj["picture"]);

            $resolution = ($width == 0 OR $height == 0) ? "default" : $width . "_" . $height;

            if ($resolution == "default") {
                return $picture;
            } else {
                if (!isset($obj[$resolution])) {
                    $img = Image::fromString(base64_decode($picture->getSource()));
                    if ($img->getWidth() >= $img->getHeight()) {
                        $img->resize(null, $height);
                        $img->crop(($img->getWidth() - $width) / 2, 0, $width, $height);
                    } else {
                        $img->resize($width, null);
                        $img->crop(0, ($img->getHeight() - $height) / 2, $width, $height);
                    }
                    $img->sharpen();
                    $img->antialias(true);
                    $picture->setWidth($width);
                    $picture->setHeight($height);
                    $picture->setSource(base64_encode((string) $img));
                    $this->collection->update(array("_id"=> $mongoId),array('$set' => array($resolution => $picture->getSource())));
                } else {
                    $picture->setWidth($width);
                    $picture->setHeight($height);
                    $picture->setSource($obj[$resolution]);
                }
            }
            return $picture;
        }
        return null;
    }

    /**
     *
     * @param \MongoId $mongoId 
     */
    public function delete(\MongoId $mongoId) {
        $this->collection->remove(array("_id" => $mongoId));
    }

    /**
     *
     * @param type $haystack
     * @param type $needle
     * @param type $desc / 1 => true
     * @return array \MongoId
     */
    public function find($haystack, $needle, $desc = 1) {
        $list = array();
        $cursor = $this->collection->find(array( $haystack => $needle ));
        foreach ($cursor as $ob) {
            $list[(string)$ob["_id"]] = $ob["_id"];
        }
        if ($desc==1) {
            rsort($list);
        } else {
            ksort($list);
        }
        return $list;
    }
    
    /**
     *
     * @param Picture $picture
     * @param ArrayHash $options / doplnujici sloupky
     * @return \Picture\Picture 
     */    
    public function save(Picture $picture, $options) {
        $list = array();
        $list["picture"] = null;
        $list["timestamp"] = time();
        $picture->setCreateDate(new \Nette\DateTime);
        if ($options instanceof \Nette\ArrayHash) {
            foreach ($options as $key => $option) {
                $list[$key] = $option;
            }
        }
        $this->collection->insert($list, array("secure" => true));
        $id = $this->collection->findOne(array(), array("_id" => $list['_id']));
        $picture->setIdPicture((string) $id["_id"]);
        $this->collection->update(array("_id" => $list["_id"]), array('$set' => array("picture" => serialize($picture))));
        return $picture;
    }

}

?>
