<?php
define('ROOT', dirname(dirname(__DIR__)));
define('MODULE', 'liste');
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
<table class="liste">
    <tr>
        <th>Id</th>
        <th>Nom</th>
    </tr>
    <?php foreach ($gedcom->getGedcomIndividus() as $individu) : ?>
    <tr class="<?php $i = empty($i) ? 1 : $i + 1; echo (($i%2) == 0? "pair" : "impair"); ?>">
        <td><?php echo  $individu->id() ?></td>
        <td><?php echo  $individu->nom() ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php foot($script); ?>
