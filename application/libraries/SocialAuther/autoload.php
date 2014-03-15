<?php


function autoloading($class)
{
    $tmp = array('CI_Exceptions','CI_Loader','SocialAuther\Adapter\facebookApi','FacebookApiException','SocialAuther\Adapter\Exception');

    //TODO :: ЕБАНЫЙ КОСТЬ!!!!!!! Связан с какой то кривотой хостинга...
    if(!in_array($class,$tmp)){
        require_once str_replace('SocialAuther/', '', str_replace('\\', '/', $class) . '.php');
    }
}