<?php

namespace App\Controller;


use App\Entity\Camera;
use App\Form\CameraType;
use App\Repository\CameraRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CameraALouer extends AbstractController
{
    /**
     * @Route("/camera_a_louer", name="location")
     */
    public function cameraALouer(CameraRepository $repo){

        $cameras = $repo->findAll();
        return $this->render('camera_a_louer.html.twig', [
            'cameras' => $cameras
        ]);
    }

    /**
     * Permet de créer une annonce
     *
     * @Route("/annonce/create", name="annonce_nouveau")
     *
     * @return Response
     */
    public function creer(){
        $annonce = new Camera();

        $form = $this->createForm(CameraType::class, $annonce);

        return $this->render('annonce/nouveau.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet d'afficher une camera à louer
     * @Route("/annonce/{slug}", name="annonce_show")
     *
     * @return Response
     */
    public function show(Camera $annonce){

        return $this->render('annonce/show.html.twig', [
            'annonce' =>$annonce
        ]);
    }

}