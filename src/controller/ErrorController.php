<?php
namespace Maxitsa\Controller;

use Maxitsa\Abstract\AbstractController;

class ErrorController extends AbstractController{
    public function error404(){
      
       $this->renderHtml("error/404.php");
    }

      public function create(){}
 }