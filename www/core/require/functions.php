<?php
/**
* NOTE : fonction pas utilisée
* Exécute un array_map récursivement
* @param string $fn fonction de rappel
* @param array $array tableau
* @return  bool  
*/
function array_map_recursive($fn, $arr) {
    $rarr = array();
    foreach ($arr as $k => $v) {
        $rarr[$k] = is_array($v)
            ? array_map_recursive($fn, $v)
            : $fn($v); // or call_user_func($fn, $v)
    }
    return $rarr;
}

/**
* Redirection 
*/
function redirect($chemin)
{
    header("location: ".$chemin);
    exit();
}

/**
* Retourne un nom de fichier lisible 
*/
function humanFormatFileName($fichier)
{
    $file_array = explode('.', $fichier);
    $extension_key = count($file_array) - 1;
    $nom = basename($fichier, '.'.$file_array[$extension_key]);
    $nom = str_replace(array('-', '_'), ' ', $nom);
    return $nom;
}

