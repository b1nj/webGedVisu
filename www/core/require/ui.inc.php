<?php
function head($head=false) {
GLOBAL $wgv, $gedcoms;
$module = $wgv->getModule();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $module['titre'] ?> - <?php echo TITRE ?></title>
    <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link type="text/css" href="../../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/ui/smoothness/jquery-ui.custom.min.css">
    <?php echo $head ?>
</head>
<body id="body">
    <a href="#" id="header_open" title="Accés au menu"><img src="../../css/header.png" alt="" /></a>
    <header id="page" class="menu_actif">
        <h1 class="titre"><?php echo TITRE ?></h1>
        <nav>
            <ul>
                <li><a class="onglet" href="../../?<?php echo $wgv->getUrlParams(); ?>">Accueil</a></li>
                <li>
                    <a href="#" class="onglet deroulant">Visualisation</a>
                    <form method="get" action="?">
                        <fieldset>
                            <legend>Vues</legend>
                            <p>
                                <label for="visu">Visualisation</label>
                                <select id="visu" name="module">
                                    <?php foreach ($wgv->getModules()->getModules() as $key => $visu) : ?>
                                        <option value="<?php echo $key ?>" <?php echo (MODULE == $key ? 'selected="selected"' : '') ?>><?php echo $visu['titre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                        </fieldset>
                        <p>
                            <?php echo $wgv->getUrlParams(array(), true); ?>
                            <input type="submit" name="envoyer" value="Visualiser">
                        </p>
                    </form>
                </li>
                <li>
                    <a href="#" class="onglet deroulant">Paramètres</a>
                    <form method="get" action="?">
                        <fieldset>
                            <legend>Général</legend>
                            <p>
                                <label for="ged">Fichier Gedcom</label>
                                <?php echo $wgv->getUrlParams(array(), true); ?>
                                <!--  onchange="submit()" -->
                                <select id="ged" name="ged" >
                                    <?php foreach ($gedcoms as $fichier => $gedcom) : ?>
                                        <option value="<?php echo $fichier ?>" <?php echo ($wgv->getGedcomFichier() == $fichier ? 'selected="selected"' : '') ?>><?php echo $gedcom->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                        </fieldset>
                        <p>
                            <input type="submit" name="envoyer" value="Modifier">
                        </p>
                    </form>
               </li>
            </ul>
        </nav>
    </header>
    <div id="slider-width" class="menu_actif"></div>
    <div id="slider-height"></div>
    <article id="visualisation">
        <h1 class="h1-like"><?php echo $module['titre'] ?></h1>

<?php
}

function foot($script=false) { ?>

    </article>
    <footer></footer>
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/jquery-ui.custom.min.js"></script>
    <script type="text/javascript" src="../../js/jquery.wgv.interface.js"></script>
    <script type="text/javascript" src="../../js/jquery.wgv.zoom.js"></script>
    <script type="text/javascript" src="../../js/jquery.mousewheel.js"></script>
    <!--<script type="text/javascript" src="../../js/scripts.js"></script>-->
    <?php echo $script ?>
</body>
</html>
<?php
}
