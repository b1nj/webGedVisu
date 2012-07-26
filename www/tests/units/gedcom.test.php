<?php

namespace core\classes\tests\units;

require_once '../mageekguy.atoum.phar';
include_once '../../core/classes/parseur.class.php';
include_once '../../core/classes/individu.class.php';
include_once '../../core/classes/famille.class.php';
include_once '../../core/classes/gedcom.class.php';

use \mageekguy\atoum;
use \core\classes;

class Gedcom extends  atoum\test
{
    public function testisValidGedcomFichier()
    {
        try {
            $gedcom = new classes\Gedcom('./ged/test1.ged');
            $this->assert
               ->boolean(false)->isTrue();   
        }
        catch (\Exception  $e) {
            $e->getMessage();
            $this->assert
               ->boolean(true)->isTrue(); 
        }
    }

   public function testisLeaf()
   {
      $gedcom = new classes\Gedcom('./ged/test2.ged');
      $this->assert
         ->boolean($gedcom->isLeaf(24))->isFalse()
      ;
      $this->assert
         ->boolean($gedcom->isLeaf(14))->isTrue()
      ;
   }
   
   public function testrecupValeur()
   {
      $gedcom = new classes\Gedcom('./ged/test2.ged');
      $this->assert
         ->string($gedcom->recupValeur(24))->isEqualTo('1 JAN 1998')
      ;
      $this->assert
         ->string($gedcom->recupValeur(182))->isEqualTo('Secondary Submitter')
      ;
   }
}

?>