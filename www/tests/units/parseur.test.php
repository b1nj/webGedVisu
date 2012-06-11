<?php

namespace tests\units;

require_once '../mageekguy.atoum.phar';

include_once '../../core/classes/parseur.class.php';

use mageekguy\atoum;
//use vendor\project;

class Parseur extends atoum\test
{
   public function isLeaf()
   {
      $parseur = new Core\Classes\Parseur();
      
      $data1 = array (
        '0 @R48@ INDI',
        '1 NAME Michael LeMoyne /Kennedy/'
      );
      $data2 = array (
        '0 @R48@ INDI',
        '0 @R49@ INDI'
      );
      $this->assert
         ->string($parseur->isLeaf($data1))->isFalse()
      ;
      $this->assert
         ->string($parseur->isLeaf($data2))->isTrue()
      ;
   }
}

?>