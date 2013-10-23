<?php
$MODULES['infovistoolkit_sunburst'] =
    array(
        'type' => 'visualisation',
        'titre' => 'Arbre généalogique ascendant circulaire',
        'description' => 'Arbre généalogique ascendant circulaire',
        'img' => 'infovistoolkit-sunburst.jpg',
        'url' => 'index.php',
        'query' => array(
            'type' => 'sunburst',
        ),        
        'module' => 'infovistoolkit'
    );
$MODULES['infovistoolkit_spacetree'] =    
    array(
        'type' => 'visualisation',
        'titre' => 'Arbre généalogique ascendant dépliant',
        'description' => 'Arbre généalogique ascendant dépliant',
        'img' => 'infovistoolkit-spacetree.jpg',
        'url' => 'index.php',
        'query' => array(
            'type' => 'spacetree',
        ),        
        'module' => 'infovistoolkit'
);
