<?php
require(ROOT.'/core/require/autoload.php');
require(ROOT.'/core/require/functions.php');
require(ROOT.'/core/require/parametres.php');
require(ROOT.'/core/require/ui.inc.php');
if (CACHE) {
    // Mettre avant session_start a cause de la mise en session de l'instance Gedcom
    require(ROOT.'/core/classes/gedcom.class.php'); 
}
session_start();

if (!defined('MODULE')) {
    define('MODULE', false);
}

/*****************************************************************
* Gestion du fichier Gedcom
******************************************************************/
$load =false;
// Récupération de la liste des fichier ged
if (!$fichiersGed = glob(ROOT.'/ged/*.{GED,ged}', GLOB_BRACE)) {
    echo 'Aucun fichier gedcom dans le repertoire "ged"';
    exit();
}
// Fichier par defaut
if (!isset($_SESSION['WVG']['FICHIER'])) {
    $_SESSION['WVG']['FICHIER'] = $fichiersGed[0];
    $_SESSION['WVG']['UPDATE'] = filemtime ($_SESSION['WVG']['FICHIER']);
}
// récupération du fichier selectionné
if (isset($_GET['ged']) and array_key_exists($_GET['ged'], $fichiersGed)) {
    
    if ($fichiersGed[$_GET['ged']] != $_SESSION['WVG']['FICHIER']) {
        $load = true;
    }
    $_SESSION['WVG']['FICHIER'] = $fichiersGed[$_GET['ged']];
}
// Chargement si fichier modifié
if ($_SESSION['WVG']['UPDATE'] < filemtime ($_SESSION['WVG']['FICHIER'])) {
    $load = true;
    $_SESSION['WVG']['UPDATE'] = filemtime ($_SESSION['WVG']['FICHIER']);
}
//Instanciation de la class Gedcom et mise en session de l'objet $gedcom
if (CACHE and !$load and isset($_SESSION['GEDCOM'])) {
    $gedcom = $_SESSION['GEDCOM'];
}
if (!isset($gedcom) or $load) {
    $gedcom = new core\classes\Gedcom($_SESSION['WVG']['FICHIER']);
}
if (CACHE) {
    function session($gedcom) {
        $_SESSION['GEDCOM'] = $gedcom;
    }
    register_shutdown_function('session',$gedcom);
}

/*****************************************************************
* Routages
******************************************************************/
// Récupération de la liste des modules installés
if (!$modules = glob(ROOT.'/modules/*/parametres.php')) {
    echo "Aucun module installé.";
    exit();
}
$MODULES = array();
foreach ($modules as $key => $module) {
    require ($module);
}
// Redirection vers le module selectionné
if (isset($_GET['module']) and array_key_exists($_GET['module'], $MODULES)) {
    redirect('../'.$MODULES[$_GET['module']]['module'].'/'.$MODULES[$_GET['module']]['url']);
}
