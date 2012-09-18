<?php

try
{
        /*** the image file ***/
        $image = 'images/logo2.jpg';

        /*** a new imagick object ***/
        $im = new Imagick();

        /*** ping the image ***/
        $im->pingImage($image);

        /*** read the image into the object ***/
        $im->readImage( $image );

        /**** convert to png ***/
        $im->setImageFormat( "png" );

        /*** write image to disk ***/
        $im->writeImage( 'images/logo2.png' );

        echo 'Image Converted';
}
catch(Exception $e)
{
        echo $e->getMessage();
}

?>
