<?php
namespace core\classes;

class Individu {
    
    protected $id,
              $nom,
              $sosa,
              $familleConception = false, //FAMC
              $familleCouple = false,     //FAMS
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
        if (isset($donnees['NAME']))
            $this->setNom($donnees['NAME']);
        if (isset($donnees['FAMC']))
            $this->setFamilleConception($donnees['FAMC']);
        if (isset($donnees['FAMS']))
            $this->setFamilleCouple($donnees['FAMS']);
        $this->setGedcom($donnees);
    }   
    
    // SETTERS //
    public function setId($id)
    {
        //$this->id = (int) $id;
        $this->id = $id;
    }
    public function setNom($valeur)
    {
        $this->nom = $valeur;
    }
    public function setSosa($valeur)
    {
        $this->sosa = $valeur;
    }
    public function setFamilleConception($valeur)
    {
        $this->familleConception = $valeur;
    }
    public function setFamilleCouple($valeur)
    {
        $this->familleCouple = $valeur;
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
    public function nom()
    {
        return $this->nom;
    }
    public function sosa()
    {
        return $this->sosa;
    }
    public function familleConception()
    {
        return $this->familleConception;
    }
    public function familleCouple()
    {
        return $this->familleCouple;
    }
    public function gedcom()
    {
        return $this->gedcom;
    }
}
?>