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

/*
// Désactivation de la session, pas vraiment utile et pose des problèmes de mise a jours des fichiers gedcoms
// A controler utiliter plus tard 
// Instanciation de la class WebGedVisu et mise en session de l'objet $wgv
if (isset($_SESSION['WVG'])) {
    $wgv = $_SESSION['WVG'];
    $wgv->setGedcom($_GET['ged']);
    $wgv->setModule($_GET['module']);
} else {
    $wgv = new \WebGedVisu\core\WebGedVisu($_GET['ged'], $_GET['module']);
}
register_shutdown_function(array($wgv, 'session'));
*/


$wgv = new WebGedVisu($_GET['ged'], $_GET['module']);

if (CACHE) {
    $gedcom = ObjetCache::getInstance('\WebGedVisu\core\Gedcom', $wgv->getGedcomFichier(), $wgv->getGedcomdate());
} else {
    $gedcom = new Gedcom($wgv->getGedcomFichier());
}
