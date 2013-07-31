<?php
namespace WebGedVisu\modules\d3;
 
class Arbre extends  \WebGedVisu\core\Arbre {
    
    protected function node($identifiant)
    {
        $individu = $this->gedcom->getIndividu($identifiant);
        $individuGed = $individu->gedcom();
        if ($identifiant == $this->deCujus) {
            $individu->setSosa(1);
        }
        $children = false;
        if ($individu->familleConception()) {
            $children =  array();
        }
        $node = array(
                    'id' => 'node'.$identifiant,
                    'name' => $individu->nom(),
                    //'name' => $individu->sosa(), 
                    'children' => $children
                );
        if ($individu->familleConception()) {
            $famille = $this->gedcom->getfamille($individu->familleConception());
            if ($famille->pere()) {
                $this->gedcom->getIndividu($famille->pere())->setSosa($individu->sosa()*2);
                $node['children'][] = $this->node($famille->pere());
            }
            if ($famille->mere()) {
                $this->gedcom->getIndividu($famille->mere())->setSosa(($individu->sosa()*2) + 1);
                $node['children'][] = $this->node($famille->mere());
            }
        }        
        return $node;
    }
}
?>