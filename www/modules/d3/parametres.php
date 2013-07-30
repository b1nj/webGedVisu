<?php
$MODULES['d3_tree'] =
    array(
        'type' => 'visualisation',
        'titre' => 'd3 tree',
        'description' => 'Arbre généalogique ascendant',
        'url' => 'index.php',
        'query' => array(
            'type' => 'tree',
        ),
        'module' => 'd3'
    );
$MODULES['d3_tree-radial'] =
    array(
        'type' => 'visualisation',
        'titre' => 'd3 tree radial',
        'description' => 'Arbre généalogique ascendant circulaire',
        'url' => 'index.php',
        'query' => array(
            'type' => 'tree-radial',
        ),        
        'module' => 'd3'
    );
