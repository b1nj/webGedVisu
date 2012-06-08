<?php
define('ROOT', __DIR__);
require ROOT.'/core/require/commun.php';
head();

foreach ($visus as $key => $visu) : ?>
    <div>
        <h2><?php echo $visu['titre'] ?></h2>
        <p><?php echo $visu['description'] ?></p>
    </div>
<?php endforeach;

foot();
?>
