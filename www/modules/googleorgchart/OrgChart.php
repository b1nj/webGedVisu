<?php
namespace WebGedVisu\modules\googleOrgChart;

class OrgChart extends \WebGedVisu\core\Gedcom {
    
    protected $orgChart;
    
    public function getOrgChart()
    {
        return $this->orgChart;
    }

    /**
    * Constructeur de Gedcom
    */
    public function __construct(\WebGedVisu\core\Gedcom $donnees)
    {
        $this->hydrate($donnees);
        $this->orgChart();
    }
    
    public function orgChart() {
        // Création du tableau google orgchart
        $orgchart = array();

        $familles = $this->gedcomFamilles;
        foreach ($this->gedcomIndividus as $key => $individu) {
            if ($individu->familleCouple() and $individu->nom() != '') {
                $individuGed = $individu->gedcom();
                $famille = $this->getfamille($individu->familleCouple());
                // TODO : atention ne gére qu'un seul enfant
                $orgchart[] = array(
                    '{v:\''.$key.'\','.
                     ' f:\''.(isset($individuGed['_SOSA']) ? '<class style="color: red;">'.$individuGed['_SOSA'].'</class><br />' : '').
                    ' '.addslashes($individu->nom()).' ('.(isset($individuGed['BIRT']['DATE'] ) ? addslashes($individuGed['BIRT']['DATE']) : '').
                    '&nbsp;-&nbsp;'.(isset($individuGed['DEAT']['DATE'] ) ? $individuGed['DEAT']['DATE'] : '').')\'}' ,
                    "'".$famille->enfants()."'",
                    "''"
                    );
            }
        }
        //print_r($orgchart);
        // rsort($orgchart); TODO : il faut trier le tableau par sosa
        $orgchart_addRows = '';
        foreach ($orgchart as $value) {
            $orgchart_addRows .= '['.implode(', ', $value).'], ';
        }
        // Suppression du dernuier caractère
        $this->orgChart = substr($orgchart_addRows,0, -2);
        
        return $this->orgChart;
    }
}   