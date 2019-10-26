<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CameraALouer extends AbstractController
{
    /**
     * @Route("/Camera_a_louer", name="location")
     */
    public function cameraALouer(){
        return $this->render('camera_a_louer.html.twig');
    }
}