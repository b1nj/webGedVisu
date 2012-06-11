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
    <?php echo $head ?>
</head>
<body>
    <header id="page">
        <h1><?php echo TITRE ?></h1>
        <nav>
            <ul>
                <li><a class="onglet" href="<?php echo URL ?>">Accueil</a></li>
                <li>
                    <a href="<?php echo URL ?>" class="onglet">Paramètres</a>
                    <form method="get" action="">
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
    <section>
        <article>
            <header>
                <h1><?php echo MODULE ? $MODULES[MODULE]['titre'] : 'Accueil' ?></h1>
            </header>    
<?php
}

function foot($script=false) { ?>
        </article>
    </section>
    <footer></footer>
    <?php echo $script ?>
</body>
</html>
<?php
}
?>