<?php 
namespace WebGedVisu\core;
 
class GedcomsParametres {
    
    protected $fichier_xml;
    protected $gedcoms = array();
    protected $xml = null;
    protected $is_nouveau_gedcom;
    
   /**
    * Constructeur
    * @param string chemin absolue du fichier
    */
    public function __construct($fichier_xml)
    {
        $this->fichier_xml = $fichier_xml;
    }
    
   /**
    * Chargement du fichier xml
    * @param bool creation du fichier s'il n'existe pas
    */
    public function load($create = true)
    {
        $this->is_nouveau_gedcom = false;
        if (!file_exists($this->fichier_xml)) {
            $this->create();
        } else {
            $this->xml = new \SimpleXMLElement($this->fichier_xml, 0, true);
            // Lecture du xml
            foreach ($this->xml->gedcom as $gedcom) {
                $this->gedcoms[(string) $gedcom->file] = $gedcom;
            }
        }
    }
    
   /**
    * Sauvegarde dans le fichier xml
    * @return bool
    */
    public function save()
    {
        if ($this->xml === null) {
            return false;
        }
        if (!$this->is_nouveau_gedcom) {
            // Pas de modification, pas besoin de sauvegarder
            return true;
        }
        // passage par DOMDocument pour formater l'affichage du xml (indentation)
        $dom = new \DOMDocument(); 
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML(dom_import_simplexml($this->xml)->ownerDocument->saveXML());
        if ($dom->save($this->fichier_xml)) {
            $this->is_nouveau_gedcom = false;
        } else {
            return false;
        }
    }    
    
   /**
    * Création du fichier xml
    */
    public function create()
    {
        $xmlstr = "<?xml version='1.0' encoding='UTF-8'?>\n<gedcoms />";
        $this->xml = new \SimpleXMLElement($xmlstr);
        $this->is_nouveau_gedcom = true;
    }  
    
   /**
    * Ajout d'un gedcom dans le fichier
    */
    public function addGedcom($file_gedcom)
    {
        if ($this->xml === null) {
            return false;
        }        
        if (!$this->existGedcom($file_gedcom)) {
            // Nouveau fichier
            $xml_gedcom = $this->xml->addChild('gedcom');
            $xml_gedcom->addChild('name', basename($file_gedcom));
            $xml_gedcom->addChild('file', basename($file_gedcom));
            $this->is_nouveau_gedcom = true;
        }
    }
        
    /**
    * vérifie l'existence d'un gedcom dans le fichier
    */
    public function existGedcom($file_gedcom)
    {
        return array_key_exists(basename($file_gedcom), $this->gedcoms);
    }
    
    // GETTERS //
    public function getGedcoms()
    {
        return $this->gedcoms;
    } 
    public function getGedcom($file_gedcom)
    {
        if (!$this->existGedcom($file_gedcom)) {    
            return false;
        }
        return $this->gedcoms[basename($file_gedcom)];
    }  
}