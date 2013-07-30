<?php 
namespace core\classes;

 
class WebGedVisu {
    
    protected $modules;
    protected $gedcoms;
    public $module; // TODO provisoire
    protected $gedcomFichier;
    protected $gedcomKey;
    protected $gedcomDate;
    

   /**
    * Constructeur
    */
    public function __construct($gedcom = false, $module = false)
    {
        $this->gedcoms = new Gedcoms();
        $this->modules = new Modules();
        $this->setGedcom($gedcom ? $gedcom : 0); // 0 : Premier gedcom de la liste
        $this->setModule($module ? $module : DEFAUT_MODULE);
    }
    
   /**
    * Défini le fichier Gedcom
    * @param string $gedcom_fichier
    */
    public function setGedcom($gedcomKey)
    {
        if ($gedcomKey !== false and $gedcomKey !== $this->gedcomKey) {            
            if (array_key_exists($gedcomKey, $this->gedcoms->getGedcoms())) {
                $this->gedcomKey = $gedcomKey;
                $gedcoms = $this->gedcoms->getGedcoms();
                $this->gedcomFichier = $gedcoms[$this->gedcomKey];
                $this->gedcomDate = filemtime($this->gedcomFichier);
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
    	$key_module = $key_module ? $key_module : DEFAUT_MODULE;
        $this->module = $this->modules->getModule($key_module);
        $this->goToModule($key_module);
    }
    
   /**
    * Redirige vers le module
    */
    public function goToModule($key_module)
    {
        if (MODULE != $key_module) {
            redirect((!MODULE ? '' : '../../').Modules::REPERTOIRE.'/'.$this->module['module'].'/'.$this->module['url']);            
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
        return $this->gedcomFichier;
    }
    public function getGedcomKey()
    {
        return $this->gedcomKey;
    }
    public function getGedcomDate()
    {
        return $this->gedcomDate;
    }    
    
    public function session()
    {
        $_SESSION['WVG'] = $this;
    }
}
