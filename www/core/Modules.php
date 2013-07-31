<?php 
namespace WebGedVisu\core;
 
class Modules {
    
    protected $modules = false;
    
    const REPERTOIRE = 'modules';
    const NOM_FICHIER_PARAMETRE = 'parametres.php';
    

   /**
    * Constructeur de module
    */
    public function __construct()
    {
        $this->getModules();
    }
    
    /**
    * Récupération de la liste des modules installés
    */
    public function getModules()
    {
        if (!$this->modules) {
            if (!$modules = glob(ROOT.'/'.self::REPERTOIRE.'/*/'.self::NOM_FICHIER_PARAMETRE)) {
                throw new \Exception  ('Aucun module installé.');
            }
            $MODULES = array();
            foreach ($modules as $key => $module) {
                require ($module);
            }
            $this->modules = $MODULES;
        }
        return $this->modules;
    }
    
    /**
    * Récupération des informations d'un module
    * @param string $key_module
    * @return array $infos
    */
    public function getModule($key_module)
    {
        if (!isset($this->modules[$key_module])) {
            return false;
        }
        return $this->modules[$key_module];
    }
}