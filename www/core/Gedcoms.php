<?php 
namespace WebGedVisu\core;
 
class Gedcoms {
    
    protected $gedcoms = false;
    
    const REPERTOIRE = 'ged';
    const EXTENSION_FICHIER = '{GED,ged}';
    const NOM_FICHIER_PARAMS = 'gedcoms.xml';
    

   /**
    * Constructeur de module
    */
    public function __construct()
    {
        $this->getGedcoms();
    }
    
    /**
    * Récupération de la liste des modules installés
    * return  $gedcoms array
    */
    public function getGedcoms()
    {
        if (!$this->gedcoms) {
            if (!$gedcoms = glob(ROOT.'/'.self::REPERTOIRE.'/*.'.self::EXTENSION_FICHIER, GLOB_BRACE)) {
                throw new \Exception  ('Aucun fichier gedcom dans le repertoire "ged".');
            }
            if (!file_exists(ROOT.'/'.self::REPERTOIRE.'/.'.self::NOM_FICHIER_PARAMS)) {
                $xmlstr = "<?xml version='1.0' standalone='yes'?>\n<gedcoms></gedcoms>";
                $xml = new \SimpleXMLElement($xmlstr);
                $xml->asXML(ROOT.'/'.self::REPERTOIRE.'/.'.self::NOM_FICHIER_PARAMS);
            }
            $this->gedcoms = $gedcoms;
        }
        return $this->gedcoms;
    }
    
    /**
     * Retourne le premier fichier Gedcom
     */
     public function defaut()
     {
         return $this->gedcoms[0];
     }
}
