<?php
namespace WebGedVisu\core;

class Arbre {
    protected $deCujus;

    protected $arbre = array();
    protected $gedcom;


   /**
    * Constructeur de Arbre
    */
	public function __construct(Gedcom $gedcom, $deCujus=false )
	{
		if ($deCujus) {
		    $this->deCujus = $deCujus;
        } elseif ($gedcom->deCujus) {
            $this->deCujus = $gedcom->deCujus;
		} else {
            $individus = $gedcom->getGedcomIndividus();
            $this->deCujus =  key($individus);
        }
        $this->gedcom = $gedcom;
        $this->creerArbre();
	}

   /**
    * Constructrion de l'arbre
    */
	public function creerArbre()
	{
		$this->arbre = $this->node($this->deCujus);
	}

	/**
	 * Récupère les individus sous forme d'arbre
	 * $identifiant identifiant de l'individu
	 * return array
	 */
	protected function node($identifiant)
    {
        $individu = $this->gedcom->getIndividu($identifiant);
        $node = array(
                    $identifiant => array()
                );
        if ($individu->familleConception()) {
            $famille = $this->gedcom->getfamille($individu->familleConception());
            if ($famille->pere())
                $node[$identifiant][] = $this->node($famille->pere());
            if ($famille->mere())
                $node[$identifiant][] = $this->node($famille->mere());
        }
        return $node;
	}

    // GETTERS //
    public function getArbre()
    {
        return $this->arbre;
    }
}