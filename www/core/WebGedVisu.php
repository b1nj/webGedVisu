<?php 
namespace WebGedVisu\core;

 
class WebGedVisu {
    
    protected $gedcoms;
    public $module; // TODO provisoire
    protected $gedcomFichier;
    protected $repertoire;
    protected $repertoireRealPath;
    

   /**
    * Constructeur
    */
    public function __construct($gedcomFichier = false, $module = false, $repertoire = false)
    {
        //$this->gedcoms = new Gedcoms();
        $this->modules = new Modules();
        $this->setGedcomFichier($gedcomFichier); 
        $this->setRepertoire($repertoire);
        $this->setModule($module ? $module : DEFAUT_MODULE);
    }

   /**
    * Défini le fichier Gedcom
    * @param string $gedcom_fichier
    */
    public function setGedcomFichier($gedcomFichier)
    {
        $this->gedcomFichier = $gedcomFichier;
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
            $query = str_replace('&amp;', '&', isset($module['query']) ? $this->getUrlParams($module['query']) : $this->getUrlParams());
            redirect((!MODULE ? '' : '../../').Modules::REPERTOIRE.'/'.$module['module'].'/'.$module['url'].'?'.$query);            
        }    
    }

   /**
    * Défini le sous repertoir des fichiers gedcoms
    * @param string $repertoire
    */
    public function setRepertoire($repertoire = false)
    {
        $rep = ROOT.'/'.Gedcoms::REPERTOIRE.($repertoire ? '/'.$repertoire : '').'/';             
        if (file_exists($rep)) {
            $this->repertoire = $repertoire ? $repertoire : null;
            $this->repertoireRealPath = $rep;
        } else {
            throw new \Exception  ('Le repertoire "'.Gedcoms::REPERTOIRE.($repertoire ? '/'.$repertoire : '').'" n\'existe pas.');
        }
    }

        
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
    public function getRepertoire()
    {
        return $this->repertoire;
    }
    public function getRepertoireRealPath()
    {
        return $this->repertoireRealPath;
    }     
        
    public function getUrlParams($params = array(), $input = false)
    {
        $parametres = array(
            'ged' => $this->getGedcomFichier(),
            'rep' => $this->getRepertoire(),
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
        
}
