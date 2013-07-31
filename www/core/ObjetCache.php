<?php
namespace WebGedVisu\core;

/**
 * Cache d'objet dans des fichiers
 * @author Patrick Poulain :: version simplifié
 * @license GPL
 * @see http://petitchevalroux.net
 * @see http://dev.petitchevalroux.net/php/cache-objet-dans-des-fichiers-php.345.html
 */
class ObjetCache
{
    /* @var string Chemin où sont stockés les objets */
    const cachePath = '../../cache/objets';
    
    /**
     * Retourne l'instance d'un object depuis le cache ou le crée si nécessaire
     *
     * @param string $class classe de l'objet
     * @param string/int $id identifiant de l'objet
     * @return ObjectCache
     */
    public static function getInstance ($class, $id, $date)
    {
        $strId = (string) rawurlencode(basename($id));

        /*Construction du path du fichier de cache*/
        $path = self::cachePath.'/'.basename($class).'/'.$strId.'.obj';
        
        /*Si le fichier de cache est valide*/
        if (file_exists($path) and filemtime($path) >= $date) {
            /*On récupère la version en cache*/
            $object = unserialize(gzuncompress(file_get_contents($path)));
            /*Si on a réussi la désérialisation on retourne l'objet*/
            if ($object !== false) {
                $instance = $object;
                unset($object);
                return $instance;
            }
        }
        /*Le cache n'est pas valide ou la désérialisation a échoué on construit à nouveau l'objet*/
        $instance = new $class($id);

        $cache = gzcompress(serialize($instance));
        /*Si l'ecriture du fichier échoue c'est certainement que le répertoire n'existe pas*/
        if (false === ($cacheOk = @file_put_contents($path, $cache))) {
            /*On crée le répertoire et on tente a nouveau de créer le fichier de cache*/
            mkdir(dirname($path), 0777, true);
            $cacheOk = file_put_contents($path, $cache);
        }
        return $instance;
    }
}
