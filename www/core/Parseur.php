<?php

namespace WebGedVisu\core;

abstract class Parseur {

    protected $gedcomFichier = null;
    protected $fichierContenu = array();
    protected $gedcom = array();
    protected $gedcomIndividus = array();
    protected $gedcomFamilles = array();


    /**
     * Lance le parsage du fichier
     *
     * @access protected
     * @return null
     */
    protected function parse()
    {
        $this->fichierContenu();
        if ($this->isValidGedcomFichier()) {
            $this->gedcom = $this->parseNode(0,0);
            $this->parseArbre();
        } else {
            throw new \Exception($this->gedcomFichier.' is not a valid Gedcom file.');
        }
    }
    /**
     * Lit le fichier Gedcom
     *
     * @access protected
     * @return null
     */
    protected function fichierContenu()
    {
        $buffer = array();
        if ($fp = @fopen($this->gedcomFichier, 'r')) {
            while (!feof($fp)) {
                $buffer[] = trim(fgets($fp, 1024));
            }
            fclose($fp);
            // unset the last line if it's empty
            if (empty($buffer[count($buffer) - 1])) {
                unset($buffer[count($buffer) - 1]);
            }
            $this->fichierContenu = $buffer;
            unset($buffer);
        } else {
    		throw new \Exception  ('Cannot open file '.$this->gedcomFichier);
        }
    }
    
    /**
     * Test if it's a valid gedcom file
     *
     * @access protected
     * @return boolean
     */
    protected function isValidGedcomFichier()
    {
        return (($this->fichierContenu[0] == '0 HEAD')  && ($this->fichierContenu[count($this->fichierContenu) - 1] == '0 TRLR'))
        ? true : false;
    }

    /**
     * Parse Gedcom tree
     *
     * Separate Gedcom tree in 4 parts:
     * gedcom file header, individuals, families, objects.
     *
     * @access protected
     * @return null
     */
    protected function parseArbre()
    {
        //$this->gedcomIndividus = $this->gedcom['INDI'];
        //$this->gedcomFamilles = $this->gedcom['FAM'];
        foreach ($this->gedcom['INDI'] as $key => $value) {
            $this->gedcomIndividus[$key] = new Individu($value);
        }
        foreach ($this->gedcom['FAM'] as $key => $value) {
            $this->gedcomFamilles[$key] = new Famille($value);
        }
    }

    /**
     * Parse le fichier Gedcom
     *
     * Fonction récursive
     *
     * @access protected
     * @return arbre
     */
    protected function parseNode($key, $niveau) 
    {
        // Initialisation
        $cols_tag = $niveau == 0 ? 2 : 1;
        $nodes = '';
        $ligne = $this->parseLigne($this->fichierContenu[$key]);
        while ($ligne[1] != 'TRLR'  and $ligne[0] >= $niveau) {
            $buffer = $this->fichierContenu[$key];
            //echo $niveau;
            if ($ligne[0] == $niveau) {
                // Lecture du TAG
                if (isset($ligne[$cols_tag])) {
                    $tag = $ligne[$cols_tag];
                    
                    $valeur = $this->recupValeur($buffer);
                    if ($this->isLeaf($key)) {
                        if (isset($ligne[2]) and $identifiant = $this->nettoyageIdentifiant($ligne[2])) {
                            $donnee = $identifiant;
                        }
                        else {
                            // Récupération de la valeur
                            //$donnee = $this->recupValeur($buffer);
                            $donnee = $valeur;
                        }
                        $valeur = '';
                    }
                    else {
                        // récup des child
                        $donnee = $this->parseNode($key + 1, $niveau + 1);
                    }
                    $identifiant = $this->nettoyageIdentifiant($ligne[1]);
                    if (!$identifiant) {
                        if (empty($valeur)) {
                            // cas des CHIL
                            if (isset($nodes[$tag]) and $tag == 'CHIL') {
                                if (!is_array($nodes[$tag])) {
                                    $node = $nodes[$tag];
                                    $nodes[$tag] = array();
                                    $nodes[$tag][] = $node;
                                }
                                $nodes[$tag][] = $donnee;
                            }
                            else {
                                $nodes[$tag] = $donnee;
                            }
                        }
                        else {
                            $nodes[$tag] = $valeur;
                            $nodes[$tag.'###'] = $donnee;
                        }
                    }
                    else {
                        $donnee['id'] = $identifiant;
                        $nodes[$tag][$identifiant] = $donnee;
                    }   
                }
            }
            $key++;
            $ligne = $this->parseLigne($this->fichierContenu[$key]);
        }
        return $nodes;  
    }
    
    /**
    * parse une ligne gedcom
    * @return array
    */
    protected function parseLigne($buffer) 
    {
        $ligne = explode(' ', $buffer);
        return $ligne;
    }
	
    /**
     * Vérifie l'existence d'une autre node
	 * @return boolean
     */
    protected function isLeaf($key)
    {
        $ligne = $this->parseLigne($this->fichierContenu[$key]);
        $ligne2 = $this->parseLigne($this->fichierContenu[$key+1]);
        return $ligne2[0] > $ligne[0] ? false : true;
    }
    
    protected function nettoyageIdentifiant($identifiant)
    {
        if (strpos($identifiant,'@') === false) {
            return false;
        }
        $identifiant = trim($identifiant);
        //$trans = array("@N" => "", "@S" => "", "@R" => "", "@I" => "", "@F" => "", "@B" => "", "@" => "");
        $trans = array("@" => "");
        $identifiant = strtr($identifiant, $trans);
        return $identifiant;
    }
    protected function recupValeur($ligne)
    {
        $array = explode(' ', $ligne);
        $nb_soustract = strlen($array[0]) + strlen($array[1]) + 2;
        $valeur = substr($ligne, $nb_soustract);
        return trim($valeur);
    }

    /**
    * Récupére les PLAC
    */
    public function getPlaces() 
    {
        $places = false;
        foreach ($this->fichierContenu as $lig) {
            $ligne = $this->parseLigne($lig);
            if (isset($ligne[1])  and $ligne[1] == 'PLAC' and !empty($ligne[2])) {
                $places[] = $this->recupValeur($lig);
            }
        }
        return $places;
    }
}
