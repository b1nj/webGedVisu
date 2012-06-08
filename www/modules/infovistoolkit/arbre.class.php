<?php
namespace Modules\InfoVisToolkit;
 
class Arbre extends  \Core\Classes\Arbre {
    
    protected function node($identifiant)
    {
        $individu = $this->gedcom->getIndividu($identifiant);
        $individuGed = $individu->gedcom();
        if ($identifiant == $this->deCujus) {
            $individu->setSosa(1);
        }
        $node = array(
                    'id' => 'node'.$identifiant,
                    'name' => $individu->sosa(), //$individuGed['_SOSA']
                    'data' => array (
                        '$color' => ($individuGed['SEX'] == 'F' ? "#f7b5cb" : "#6bbdef"),
                        'description' => '<class style="color: red;">'.
                                          $individu->sosa().'</class><br />'.
                                          str_replace('/', '', $individu->nom()).
                                          '<br /> ('.(isset($individuGed['BIRT']['DATE'] ) ? $individuGed['BIRT']['DATE'] : '').'&nbsp;-&nbsp;'.
                                          (isset($individuGed['DEAT']['DATE'] ) ? $individuGed['DEAT']['DATE'] : '').')'
                    ),
                    'children' => array()
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