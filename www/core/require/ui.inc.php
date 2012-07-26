<?php
function head($head=false) {
GLOBAL $fichiersGed, $MODULES;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo MODULE ? $MODULES[MODULE]['titre'] : 'Accueil' ?> - <?php echo TITRE ?></title>
    <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link type="text/css" href="<?php echo URL ?>/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URL ?>/css/ui/base/jquery.ui.all.css">
    <?php echo $head ?>
</head>
<body id="body">
    <header id="page">
        <h1 class="titre"><?php echo TITRE ?></h1>
        <nav>
            <ul>
                <li><a class="onglet" id="close" href="#">Close</a></li>
                <li><a class="onglet" href="<?php echo URL ?>">Accueil</a></li>
                <li>
                    <a href="#" class="onglet deroulant">Paramètres</a>
                    <form method="get" action="?">
                        <fieldset>
                            <legend>Général</legend>
                            <p>
                                <label for="ged">Fichier</label>
                                <!--  onchange="submit()" -->
                                <select id="ged" name="ged" >
                                    <?php foreach ($fichiersGed as $key => $fichier) : ?>
                                        <option value="<?php echo $key ?>" <?php echo ($_SESSION['WVG']['FICHIER'] == $fichier ? 'selected="selected"' : '') ?>><?php echo basename($fichier) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                            <p>
                                <label for="visu">Visualisation</label>
                                <select id="visu" name="module">
                                    <?php foreach ($MODULES as $key => $visu) : ?>
                                        <option value="<?php echo $key ?>" <?php echo (MODULE == $key ? 'selected="selected"' : '') ?>><?php echo $visu['titre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                        </fieldset>
                        <p>
                            <input type="submit" name="envoyer" value="Envoyer">
                        </p>
                    </form>
                </li>
            </ul>
        </nav>
    </header>
    <div id="slider-width"></div>
    <div id="slider-height"></div>
    <article id="visualisation">
        <h1 class="h1-like"><?php echo MODULE ? $MODULES[MODULE]['titre'] : 'Accueil' ?></h1>

<?php
}

function foot($script=false) { ?>

    </article>
    <footer></footer>
    <script type="text/javascript" src="<?php echo URL ?>/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="<?php echo URL ?>/js/jquery-ui-1.8.22.custom.js"></script>
    <script type="text/javascript" src="<?php echo URL ?>/js/jquery.ui.slider.min.js"></script>
    <script type="text/javascript" src="<?php echo URL ?>/js/jquery.ui.widget.min.js"></script>
    <script type="text/javascript" src="<?php echo URL ?>/js/jquery.ui.mouse.min.js"></script>
    <script type="text/javascript" src="<?php echo URL ?>/js/scripts.js"></script>
    <?php echo $script ?>
    <script type="text/javascript">
        if(typeof(view)!="undefined"){ view(); }
    </script>
</body>
</html>
<?php
}
