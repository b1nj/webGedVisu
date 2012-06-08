<?php
function autoload($class)
{
    require_once ROOT.'/'.str_replace('\\', '/', strtolower($class)).'.class.php';
}
    
spl_autoload_register('autoload');
?>