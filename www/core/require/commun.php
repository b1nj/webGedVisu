<?php
require(ROOT.'/core/require/autoload.php');
require(ROOT.'/core/require/functions.php');
require(ROOT.'/core/require/parametres.php');
require(ROOT.'/core/require/ui.inc.php');
if (CACHE) {
    require(ROOT.'/core/classes/gedcom.class.php'); // Obligatoire a cause de la mise en session de l'instance Gedcom
}
session_start();

/*****************************************************************
* Gestion du fichier Gedcom
******************************************************************/
$load =false;
// Récupération de la liste des fichier ged
if (!$fichiersGed = glob(ROOT.'/ged/*.ged')) {
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
    $gedcom = new Core\Classes\Gedcom($_SESSION['WVG']['FICHIER']);
    echo 'chargement';
}
if (CACHE) {
    function session($gedcom) {
        $_SESSION['GEDCOM'] = $gedcom;
    }
    register_shutdown_function('session',$gedcom);
}

/*****************************************************************
* Gestion des visualisations
******************************************************************/
// Récupération de la liste des modules
if (!$modules = glob(ROOT.'/modules/*/parametres.php')) {
    echo 'Aucun module d\'installé';
    exit();
}
$visus = array();
foreach ($modules as $key => $module) {
    require ($module);
    $visus = $visus + $visualisations;
}
// Visualisation par defaut
if (!isset($_SESSION['WVG']['VISU'])) {
    $_SESSION['WVG']['VISU'] = $visus[0];
}
// récupération de la visualisation selectionnée
if (isset($_GET['visu']) and array_key_exists($_GET['visu'], $visus)) {
    $_SESSION['WVG']['VISU'] = $visus[$_GET['visu']];
    // redirection
    redirect(URL.'/modules/'.$_SESSION['WVG']['VISU']['module'].'/'.$_SESSION['WVG']['VISU']['url']);
}

?>