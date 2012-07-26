<?php
namespace core\classes;

class Famille {
    
    protected $id,
              $pere = false,
              $mere = false,
              $enfants = false,
              $gedcom = array();
              
    /**
     * Constructeur de la classe qui assigne les données spécifiées en paramètre aux attributs correspondants
     * @param $valeurs array Les valeurs à assigner
     * @return void
     */
    public function __construct($valeurs = array())
    {
        if (!empty($valeurs)) // Si on a spécifié des valeurs, alors on hydrate l'objet
            $this->hydrate($valeurs);
    } 
    
    /**
     * Méthode assignant les valeurs spécifiées aux attributs correspondant
     * @param $donnees array Les données à assigner
     * @return void
     */
    public function hydrate($donnees)
    {
        if (isset($donnees['id']))
            $this->setId($donnees['id']);
        if (isset($donnees['HUSB']))
            $this->setPere($donnees['HUSB']);
        if (isset($donnees['WIFE']))
            $this->setMere($donnees['WIFE']);
        if (isset($donnees['CHIL']))
            $this->setEnfants($donnees['CHIL']);
        $this->setGedcom($donnees);
    }   
    
    // SETTERS //
    public function setId($id)
    {
        $this->id = (int) $id;
    }
    public function setPere($valeur)
    {
        $this->pere = $valeur;
    }
    public function setMere($valeur)
    {
        $this->mere = $valeur;
    }
    public function setEnfants($valeur)
    {
        $this->enfants = $valeur;
    }
    public function setGedcom($gedcom)
    {
        $this->gedcom = (array) $gedcom;
    }
    
    // GETTERS //
    public function id()
    {
        return $this->id;
    }
    public function pere()
    {
        return $this->pere;
    }
    public function mere()
    {
        return $this->mere;
    }
    public function enfants()
    {
        return $this->enfants;
    }
    public function gedcom()
    {
        return $this->gedcom;
    }
}
