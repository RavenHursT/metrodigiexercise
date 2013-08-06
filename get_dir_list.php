<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mmarcus
 * Date: 8/5/13
 * Time: 1:42 PM
 * To change this template use File | Settings | File Templates.
 */

/**
 * Class dirLister
 */
class dirLister{
    protected $depth = 0;

    /**
     * @param null $d - set depth property, used for display
     */
    public function __construct($d = NULL){
        if($d){
            $this->depth = $d;
        }
    }

    /**
     * @param $path - fully qualified filesystem path
     */
    public function  getDirList($path){
        $path = rtrim($path, DIRECTORY_SEPARATOR);
        $prefix = '';
        for ($i = 0; $i < $this->depth; $i++){
            $prefix .= '-';
        }

        $files = scandir($path); //Throws warnings if permissions aren't correct.
        foreach(scandir($path) as $index => $file){
            if (!in_array($file, array('.', '..'))) {
                echo $prefix . $file . PHP_EOL;
                if(is_dir($path . DIRECTORY_SEPARATOR . $file)){
                    $lister = new dirLister($this->depth + 1);
                    $lister->getDirList($path . DIRECTORY_SEPARATOR . $file);
                }
            }
        }
    }
}



if(!isset($argv[1]) || empty($argv[1])){
    die('Usage: php get_dir_list.php [path_to_dir]' . PHP_EOL);
}

if (!is_dir($argv[1])){
    throw new Exception('Path given is a file, not a directory.  Please provide a directory.');
}

$lister = new dirLister();
$lister->getDirList($argv[1]);