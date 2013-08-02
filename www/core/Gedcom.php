<?php
namespace WebGedVisu\core;

class Gedcom extends Parseur {

    public $name = null;
    
    /**
    * Constructeur de Gedcom
    */
	public function __construct($file = false, $parametres = false, $parse = true)
	{
        if ($file) {
            $this->gedcomFichier = $file;
        }
        if ($parametres) {
            $this->setParametres($parametres);
        }
        if ($parse) {
            $this->parse();
        }
	}

    /**
     * Méthode assignant les valeurs spécifiées aux attributs correspondant
     * utilisé par les classes extends
     * @param $donnees array Les données à assigner
     * @return void
     */
    protected function hydrate(Gedcom $donnees)
    {
        $this->gedcomFichier = $donnees->getGedcomFichier();
        $this->fichierContenu = $donnees->getFichierContenu();
        $this->gedcom = $donnees->getGedcom();
        $this->gedcomIndividus = $donnees->getGedcomIndividus();
        $this->gedcomFamilles = $donnees->getGedcomFamilles();  
    }
    
    /**
     * Méthode assignant les valeurs des paarmetres spécifiées aux attributs correspondant
     * @param array $parametres
     * @return void
     */
    public function setParametres($parametres)
    {
        foreach ($parametres as $key => $parametre) {
            if (in_array($key, array('name')))  {
                $this->$key = (string) $parametre;
            }
        }
    }    
    	
    // GETTERS //
    public function getGedcomFichier()
    {
        return $this->gedcomFichier;
    }
    public function getFichierContenu()
    {
        return $this->fichierContenu;
    }
    public function getGedcom()
    {
        return $this->gedcom;
    }
    public function getGedcomIndividus()
    {
        return $this->gedcomIndividus;
    }
    public function getGedcomFamilles()
    {
        return $this->gedcomFamilles;
    }
	
    /**
     * Get un Individu (object) from an identifiant
     *
     * @param string $identifiant Identifier
     *
     * @access public
     * @return mixed object or boolean (error)
     */
    public function getIndividu($identifiant)
    {
        if ($this->isIndividu($identifiant)) {
            return $this->gedcomIndividus[$identifiant];
        } 
        return false;
    }
    
    /**
     * Get une famille (object) from an identifiant
     *
     * @param string $identifiant Identifier
     *
     * @access public
     * @return mixed object or boolean (error)
     */
    public function getFamille($identifiant)
    {
        if ($this->isFamille($identifiant)) {
            return $this->gedcomFamilles[$identifiant];
        } 
        return false;
    }
    
    /**
     * test si un idividu existe
     *
     * @param string $identifiant Identifier
     *
     * @access public
     * @return boolean
     */
    public function isIndividu($identifiant)
    {
        if (isset($this->gedcomIndividus[$identifiant])) {
            return true;
        } 
        return false;
    }
    
    /**
     * test si une famille existe
     *
     * @param string $identifiant Identifier
     *
     * @access public
     * @return boolean
     */
    public function isFamille($identifiant)
    {
        if (isset($this->gedcomFamilles[$identifiant])) {
            return true;
        } 
        return false;
    }
}
