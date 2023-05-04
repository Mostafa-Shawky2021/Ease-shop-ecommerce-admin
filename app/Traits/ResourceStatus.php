<?php
namespace App\Traits;

trait ResourceStatus
{

    // validate if the resource is external
    public static function isResoruceInternal($url)
    {

        $httpRegex = "/https?/";
        $isImageExternalLink = preg_match($httpRegex, $url);
        return (boolean) !$isImageExternalLink;
    }

}