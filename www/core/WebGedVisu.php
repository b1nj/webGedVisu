<?php 
namespace WebGedVisu\core;

 
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
        if (MODULE != $key_module) {
            $this->goToModule($key_module);
        }
        $this->module = $this->modules->getModule($key_module);
    }
    
   /**
    * Redirige vers le module
    */
    public function goToModule($key_module)
    {
        if (MODULE != $key_module) {
            $module = $this->modules->getModule($key_module);
            $query = isset($module['query']) ? str_replace('&amp;', '&', $this->getUrlParams($module['query'])) : $this->getUrlParams();
            redirect((!MODULE ? '' : '../../').Modules::REPERTOIRE.'/'.$module['module'].'/'.$module['url'].'?'.$query);            
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
    public function getUrlParams($params = array(), $input = false)
    {
        $parametres = array(
            'ged' => $this->getGedcomKey(),
        );
        $parametres = $parametres + $params;
        $value = '';
        if ($input) {
            foreach ($parametres as $key => $parametre) {
               $value .= '<input type="hidden" value="'.htmlspecialchars($parametre).'" name="'.$key.'">'; 
            }
        } else {
            foreach ($parametres as $key => $parametre) {
               $value .= $key.'='.urlencode($parametre).'&amp;'; 
            }
            $value = substr($value, 0, -5);
        }
        return $value;
    } 
        
    public function session()
    {
        $_SESSION['WVG'] = $this;
    }
}
