<?php

namespace Picture;

/**
 * Picture interface.
 *
 * @author     Martin Charouzek
 */

interface IPicture
{

    function get($idPicture,$width,$height);
    
    function save(Picture $picture);
    
    function update(Picture $picture);
    
    function delete(Picture $picture);
    
    function find($haystack, $needle, $desc);

}
