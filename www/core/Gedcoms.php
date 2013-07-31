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
            if (!$files_gedcoms = glob(ROOT.'/'.self::REPERTOIRE.'/*.'.self::EXTENSION_FICHIER, GLOB_BRACE)) {
                throw new \Exception  ('Aucun fichier gedcom dans le repertoire "ged".');
            }
            $xml_gedcoms = array();
            if (!file_exists(ROOT.'/'.self::REPERTOIRE.'/.'.self::NOM_FICHIER_PARAMS)) {
                // Création du fichier xml
                $xmlstr = "<?xml version='1.0' encoding='UTF-8'?>\n<gedcoms />";
                $xml = new \SimpleXMLElement($xmlstr);
                $xml->asXML(ROOT.'/'.self::REPERTOIRE.'/.'.self::NOM_FICHIER_PARAMS);
            } else {
                $xml = new \SimpleXMLElement(ROOT.'/'.self::REPERTOIRE.'/.'.self::NOM_FICHIER_PARAMS, 0, true);
                // Lecture du xml
                foreach ($xml->gedcom as $gedcom) {
                    $xml_gedcoms[(string) $gedcom->file] = $gedcom;
                }
            }
            
            $is_nouveau_gedcom = false;
            foreach ($files_gedcoms as $file_gedcom) {
                if (!array_key_exists(basename($file_gedcom), $xml_gedcoms)) {
                    // Nouveau fichier
                    $xml_gedcom = $xml->addChild('gedcom');
                    $xml_gedcom->addChild('name', basename($file_gedcom));
                    $xml_gedcom->addChild('file', basename($file_gedcom));
                    $is_nouveau_gedcom = true;
                }
            }
            if ($is_nouveau_gedcom) {
                // Modification du fichier
                // passage par DOMDocument pour formater l'affichage du xml (indentation)
                $dom = new \DOMDocument(); 
                $dom->preserveWhiteSpace = false;
                $dom->formatOutput = true;
                $dom->loadXML(dom_import_simplexml($xml)->ownerDocument->saveXML()); 
                $dom->save(ROOT.'/'.self::REPERTOIRE.'/.'.self::NOM_FICHIER_PARAMS);
            }
            $this->gedcoms = $files_gedcoms;
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
