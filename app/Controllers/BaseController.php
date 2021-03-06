<?php
namespace App\Controllers;

use \Twig_Loader_Filesystem; // Inicia con (/) porqueno utilizan "NameSpaces"
use \Twig_Environment;
use Zend\Diactoros\Response\HtmlResponse;// PSR7

class BaseController {
    protected $templateEngine;

    public function __construct(){
        $loader = new Twig_Loader_Filesystem('../views');
        $this->templateEngine = new Twig_Environment($loader, array(
            'debug' => true,
            'cache' => false,
        ));
    }

    public function renderHTML($fileName, $data = []) {
        return new HtmlResponse($this->templateEngine->render($fileName, $data));
    }
}