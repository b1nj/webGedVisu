<?php
// TODO : http://julien-pauli.developpez.com/tutoriels/php/autoload/ autoloat PSR0
function autoload($class) {
    if (!class_exists($class))
        require ROOT.'/'.str_replace('\\', '/', strtolower($class)).'.class.php';
}
    
spl_autoload_register('autoload');
