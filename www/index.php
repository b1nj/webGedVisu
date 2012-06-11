<?php
define('ROOT', __DIR__);
require ROOT.'/core/require/commun.php';
head();

foreach ($MODULES as $key => $visu) : ?>
    <article class="accueil">
        <h2><?php echo $visu['titre'] ?></h2>
        <p>
            <?php echo $visu['description'] ?><br>
            <a href="<?php echo URL ?>/modules/<?php echo $visu['module'] ?>/<?php echo $visu['url'] ?>">Visualiser</a>
        </p>
    </article>
<?php endforeach;

foot();
?>