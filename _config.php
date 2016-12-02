<?php
/**
 * Documentation Configuration
 *
 * Please override any of these options in your own projects _config.php file.
 * For more information and documentation see docsviewer/docs/en
 */

if(!defined('DOCSVIEWER_PATH')) {
    define('DOCSVIEWER_PATH', dirname(__FILE__));
}

if(!defined('DOCSVIEWER_DIR')) {
    $dir = explode(DIRECTORY_SEPARATOR, DOCSVIEWER_PATH);

    define('DOCSVIEWER_DIR', array_pop($dir));
}
