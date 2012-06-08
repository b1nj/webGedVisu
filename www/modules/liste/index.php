<?php
define('ROOT', dirname(dirname(__DIR__)));
require ROOT.'/core/require/commun.php';
head();
?>
<table>
    <tr>
        <th>Id</th>
        <th>Nom</th>
    </tr>
    <?php foreach ($gedcom->getGedcomIndividus() as $individu) : ?>
    <tr>
        <td><?php echo  $individu->id() ?></td>
        <td><?php echo  $individu->nom() ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php
foot();
?>
