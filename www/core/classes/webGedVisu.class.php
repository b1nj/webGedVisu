<?php 
namespace core\classes;

 
class WebGedVisu {
    
    protected $modules;
    protected $gedcoms;
    public $gedcom; // TODO provisoire
    public $module; // TODO provisoire
    protected $gedcom_fichier;
    

   /**
    * Constructeur
    */
    public function __construct($gedcom = false, $module = false)
    {
        $this->gedcoms = new Gedcoms();
        $this->modules = new Modules();
        $this->setGedcom($gedcom ? $gedcom : 0);
        $this->setModule($module ? $module : DEFAUT_MODULE);
    }
    
   /**
    * Défini le fichier Gedcom
    * @param string $gedcom_fichier
    */
    public function setGedcom($gedcom_fichier)
    {
        if ($gedcom_fichier and $gedcom_fichier !== $this->gedcom_fichier) {            
            if (array_key_exists($gedcom_fichier, $this->gedcoms->getGedcoms())) {
                $this->gedcom_fichier = $gedcom_fichier;
                $gedcoms = $this->gedcoms->getGedcoms();
                if (CACHE) {
                    $this->gedcom = ObjetCache::getInstance('\core\classes\Gedcom', $gedcoms[$this->gedcom_fichier]);
                } else {
                    $this->gedcom = new Gedcom($gedcoms[$this->gedcom_fichier]); 
                }
            } else {
                throw new \Exception  ('Le fichier Gedcom n\'existe pas.');
            }
        }
    }
    
   /**
    * Défini le module
    * @param string $key_module
    */
    public function setModule($key_module)
    {
        $this->module = $this->modules->getModule($key_module);
        $this->goToModule($key_module);
    }
    
   /**
    * Redirige vers le module
    */
    public function goToModule($key_module)
    {
        if (MODULE != $key_module) {
            redirect('../../'.Modules::REPERTOIRE.'/'.$this->module['module'].'/'.$this->module['url']);            
        }    
    }

    // SETTERS //

        
    // GETTERS //
    public function getModules()
    {
        return $this->modules;
    }
    public function getGedcoms()
    {
        return $this->gedcoms;
    }
    public function getModule()
    {
        return $this->module;
    }
    public function getGedcomFichier()
    {
        return $this->gedcom_fichier;
    }
    
    
    public function session()
    {
        $_SESSION['WVG'] = $this;
    }
}
