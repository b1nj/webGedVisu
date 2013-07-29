<?php
define('ROOT', dirname(dirname(__DIR__)));
define('MODULE', 'module_liste');
require ROOT.'/core/require/commun.php';
$head = '<link type="text/css" href="style.css" rel="stylesheet">';
$script = '
    <script type="text/javascript">
        $(function() {
            $( "#visualisation" ).interface();
        });
    </script>
';
head($head);
?>
<div class="accueil">
    <?php $i = 0; foreach ($wgv->getModules()->getModules() as $key => $visu) : ?>
        <?php echo ($i == 4 ? '<div class="row"></div>' : ""); $i = $i == 4 ? 1 : $i + 1 ?>
        <article>
            <h2><?php echo $visu['titre'] ?></h2>
            <p>
                <?php echo $visu['description'] ?><br>
                <a href="../../modules/<?php echo $visu['module'] ?>/<?php echo $visu['url'] ?>">Visualiser</a>
            </p>
        </article>
    <?php endforeach; ?>
</div>
<?php foot($script); ?>