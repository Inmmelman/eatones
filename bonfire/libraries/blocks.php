<?php

    /* Emty
     * Управляющий класс для работы с блоками вьюх
     */

class Blocks{

    private static $ci = false;

    protected static $site_path = '';

    protected static $theme_paths = '';

    protected static $default_theme = '';

    protected static $templateConfig = '';

    private static $parsedConfig = array();

    protected $_self = false;

    public function __construct(){

        self::$ci = &get_instance();
        self::init();
    }

    public static function init(){
        if ( ! self::$ci->config->item('template.theme_paths'))
        {
            self::$ci->config->load('application');
        }

        // Store our settings
        self::$site_path 		= self::$ci->config->item('template.site_path');
        self::$theme_paths 		= self::$ci->config->item('template.theme_paths');
        self::$default_theme 	= self::$ci->config->item('template.default_theme');
        self::$templateConfig   = self::loadConfig();

        self::parseConfig();
    }


    public static function getBlockView($moduleName,$blockName){

        $parsedDirArray = preg_split('/\//',$blockName);
        $blockControllerName = 'block_'.$parsedDirArray[2];

        if(is_dir(BFPATH.'blocks/'.substr($blockControllerName, 6))){
            $blockClass = new $blockControllerName;
            $blockClass->run();
        }


        return isset(self::$parsedConfig[$moduleName][$blockName]) ? self::$parsedConfig[$moduleName][$blockName] : false;
    }


    public static function loadConfig(){

        $tempalteConfigPath = self::$site_path. self::$theme_paths[0].'/'.self::$default_theme.'config/';
        $configFiles = array();

        if ($handle = opendir($tempalteConfigPath)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    $configFiles[] = $file;
                }
            }
            closedir($handle);
        }

        $config = false;

        foreach($configFiles as $singelConfig){
            $config = simplexml_load_file($tempalteConfigPath.$singelConfig);
        }

        return $config;
    }

    public static function parseConfig(){

        foreach(self::$templateConfig as $key => $config){
            $_configModuleName = $config->attributes()->name->__toString();

            foreach($config as $blockNameValue ){
                $blocksSetting[$_configModuleName][$blockNameValue->attributes()->name->__toString()] = $blockNameValue->attributes()->dir->__toString();
            }
        }

        self::$parsedConfig = $blocksSetting;
    }
}