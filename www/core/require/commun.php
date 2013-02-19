<?php
require(ROOT.'/core/require/autoload.php');
require(ROOT.'/core/require/functions.php');
require(ROOT.'/core/require/parametres.php');
require(ROOT.'/core/require/ui.inc.php');
// Mettre avant session_start a cause de la mise en session de l'instance Gedcom
require(ROOT.'/core/classes/webGedVisu.class.php'); 

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


//Instanciation de la class WebGedVisu et mise en session de l'objet $wgv
if (isset($_SESSION['WVG'])) {
    $wgv = $_SESSION['WVG'];
    $wgv->setGedcom($_GET['ged']);
    $wgv->setModule($_GET['module']);
} else {
    $wgv = new \core\classes\WebGedVisu($_GET['ged'], $_GET['module']);
}
register_shutdown_function(array($wgv, 'session'));

if (CACHE) {
    $gedcom = \core\classes\ObjetCache::getInstance('\core\classes\Gedcom', $wgv->getGedcomFichier());
} else {
    $gedcom = new \core\classes\Gedcom($wgv->getGedcomFichier());
}
