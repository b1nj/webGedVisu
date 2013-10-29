<?php 
namespace WebGedVisu\core;
 
class Gedcoms implements \Iterator, \Countable, \ArrayAccess {
    
    protected $gedcoms = array();
    
    const REPERTOIRE = 'ged';
    const EXTENSION_FICHIER = '{GED,ged}';
    const NOM_FICHIER_PARAMS = 'gedcoms.xml';
    
   /**
    * Constructeur de module
    */
    public function __construct($gedcoms = null)
    {
        if (null !== $gedcoms) {
            $this->gedcoms = $gedcoms;
        }
    }

   /**
    * Itération de l'objet
    */    
    public function count()
    {
        return count($this->gedcoms); 
    }
    public function current()
    {
        return current($this->gedcoms); 
    }
    public function next()
    {
        next($this->gedcoms);
    }
    public function valid()
    {
        return ($this->key() === NULL ? false : true);
    }
    public function key()
    {
        return key($this->gedcoms);
    }
    public function rewind()
    {
        reset($this->gedcoms);
    }
    
   /**
    * Notations d’index
    */      
    public function offsetExists($index)
    {
        return isset($this->gedcoms[$index]);
    }
    public function offsetGet($index)
    {
        return ($this->offsetExists($index) ? $this->gedcoms[$index] : false);
    }
    public function offsetSet($index, $valeur)
    {
        if (is_null($index)) {
            $this->gedcoms[] = $valeur;
        } else {
            $this->gedcoms[$index] = $valeur;
        }        
    }
    public function offsetUnset($index)
    {
        if ($this->offsetExists($index)) {
            unset($this->gedcoms[$index]);
        } 
    }

   /**
    * Alias méthodes
    */ 
    public function addGedcom($index, Gedcom $valeur)
    {
        $this->offsetSet($index, $valeur);       
    }
    public function delGedcom($index)
    {
        $this->offsetUnset($index);       
    }
             
    /**
    * Récupération de la liste des fichiers gedcom
    * @param string $repertoire  chemin absolue du repertoir contenant les fichier gedcom
    * @return array $fichiers 
    */
    static public function getFichiers($repertoire = false)
    {
        if (!$fichiers = glob($repertoire.'/*.'.self::EXTENSION_FICHIER, GLOB_BRACE)) {
            throw new \Exception  ('Aucun fichier gedcom dans le repertoire "'.self::REPERTOIRE.($repertoire ? '/'.basename($repertoire) : '').'".');
        }
        return $fichiers;
    }
}
