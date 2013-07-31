<?php
namespace WebGedVisu\core;

class Gedcom extends Parseur {

    /**
    * Constructeur de Gedcom
    */
	public function __construct($file=false)
	{
        if ($file) {
            $this->gedcomFichier = $file;
        }
        $this->parse();
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
