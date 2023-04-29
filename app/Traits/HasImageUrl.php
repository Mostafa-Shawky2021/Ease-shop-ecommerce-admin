<?php
namespace App\Traits;

trait HasImageUrl
{

    // this functin will accept the url and append the server domain name to image path 
    public static function isContainUrlSchema($url)
    {

        $httpRegex = "/https?/";

        $isImageExternalLink = preg_match($httpRegex, $url);

        return (boolean) $isImageExternalLink;
    }
}