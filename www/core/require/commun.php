<?php
namespace WebGedVisu\core;

require(ROOT.'/core/SplClassLoader.php');
$loader = new SplClassLoader('WebGedVisu', ROOT);
$loader->register();
require(ROOT.'/core/require/functions.php');
require(ROOT.'/core/require/parametres.php');
require(ROOT.'/core/require/ui.inc.php');

session_start();

if (!defined('MODULE')) {
    define('MODULE', false);
}

/*****************************************************************
* Gestion du fichier Gedcom
******************************************************************/


// récupération du fichier selectionné
$_GET['ged'] = isset($_GET['ged']) ? $_GET['ged'] : false;
// Redirection vers le module selectionné
$_GET['module'] = isset($_GET['module']) ? $_GET['module'] : MODULE;
// Sous repertoire des fichiers gedcoms
$_GET['rep'] = isset($_GET['rep']) ? $_GET['rep'] : false;

try {
    $wgv = new WebGedVisu($_GET['ged'], $_GET['module'], $_GET['rep']);
    $fichiers = Gedcoms::getFichiers($wgv->getRepertoireRealPath());
    if (!$_GET['ged']) {
        $wgv->setGedcomFichier(basename($fichiers[0]));
    }
    $params = new GedcomsParametres($wgv->getRepertoireRealPath().Gedcoms::NOM_FICHIER_PARAMS);
    $params->load();
    
    $gedcoms = new Gedcoms();
    foreach ($fichiers as $fichier) {
        if (!$params->existGedcom($fichier)) {
            $params->addGedcom($fichier);
        }
        if ($wgv->getGedcomFichier() == basename($fichier)) {
            if (CACHE) {
                $ged = ObjetCache::getInstance('\WebGedVisu\core\Gedcom', $fichier, filemtime($fichier));
            } else {
                $ged = new Gedcom($fichier);
            }
            $ged->setParametres($params->getGedcom($fichier));
            $gedcom = $ged;
        } else {
            $ged = $ged = new Gedcom($fichier, $params->getGedcom($fichier), false);
        }
        $gedcoms->addGedcom(basename($fichier), $ged);
    }
    $params->save();
    
    if (empty($gedcom)) {
        throw new \Exception  ('Le fichier Gedcom "'.$wgv->getGedcomFichier().'" n\'existe pas.');
    }
    
} catch (\Exception $e) {
    echo 'Erreur : ',  $e->getMessage(), "\n";
    exit();
}
