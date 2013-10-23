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
            $ged = new Gedcom($fichier, $params->getGedcom($fichier), false);
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

/*****************************************************************
* Autentification
******************************************************************/

$authentification = false;
$message = '';
// authentification spécifique à un répertoire
if (isset($params->getXml()->password)) {
    $authentification = true;
    if (isset($_POST['password'])) {
        if ($_POST['password'] == $params->getXml()->password) {
            $authentification = false;
            $_SESSION['acces']['repertoire'][$wgv->getRepertoire()] = true;
        } else {
            $message = 'Erreur, le mot de passe n\'est pas valide';
        }
    } elseif(!empty($_SESSION['acces']['repertoire'][$wgv->getRepertoire()])) {
        $authentification = false;
    }    
}

// authentification spécifique à un fichier
if (isset($params->getGedcom(basename($wgv->getGedcomFichier()))->password)) {
    $authentification = true;
    if (isset($_POST['password'])) {
        if ($_POST['password'] == $params->getGedcom(basename($wgv->getGedcomFichier()))->password) {
            $authentification = false;
            $_SESSION['acces']['fichier'][$wgv->getGedcomFichier()] = true;
        } else {
            $message = 'Erreur, le mot de passe n\'est pas valide';
        }
    } elseif(!empty($_SESSION['acces']['fichier'][$wgv->getGedcomFichier()])) {
        $authentification = false;
    }

}
if ($authentification) {
    head();
    formPassword($message);
    $script = '
        <script type="text/javascript">
            $(function() {
                $( "#visualisation" ).interface();
            });
        </script>
    ';    
    foot($script);
    exit();
}
