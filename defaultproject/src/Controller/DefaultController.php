<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController {

    /**
     * @Route("/", name="default_home")
     */

    public function home(){
        $series = ["a", "b", "Dexter"];
        $title = "pouf pif";

        return $this->render("default/home.html.twig", [
            "series" => $series,
            "title" => $title
        ]);
    }

    /**
     * @Route("/test/yo", name="default_test")
     */

    public function test(){

        return $this->render("default/test.html.twig");
    }
}
