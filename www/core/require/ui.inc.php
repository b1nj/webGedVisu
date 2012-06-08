<?php
function head($head=false) {
GLOBAL $fichiersGed, $visus;
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['WVG']['VISU']['titre'] ?> - <?php echo TITRE ?></title>
    <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link type="text/css" href="<?php echo URL ?>/css/style.css" rel="stylesheet">
    <?php echo $head ?>
</head>
<body>
    <header>
        <h1><?php echo TITRE ?></h1>
    </header>
    <section>
        <header>
            <h1><?php echo $_SESSION['WVG']['VISU']['titre'] ?></h1>
            <nav>
                <menu>
                    <ul>
                        <li><a class="onglet" href="<?php echo URL ?>">Accueil</a></li>
                        <li>
                            <span class="onglet">Paramètres</span>
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
                                        <select id="visu" name="visu">
                                            <?php foreach ($visus as $key => $visu) : ?>
                                                <option value="<?php echo $key ?>" <?php echo ($_SESSION['WVG']['VISU'] == $visu ? 'selected="selected"' : '') ?>><?php echo $visu['titre'] ?></option>
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
                </menu>
            </nav>
        </header>    
        <article>
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