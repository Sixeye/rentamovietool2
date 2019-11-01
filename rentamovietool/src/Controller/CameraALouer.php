<?php

namespace App\Controller;


use App\Entity\Camera;
use App\Form\CameraType;
use App\Repository\CameraRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CameraALouer extends AbstractController
{
    /**
     * @Route("/camera_a_louer", name="location")
     */
    public function cameraALouer(CameraRepository $repo)
    {

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
    public function creer(Request $request, ObjectManager $manager)
    {
        $annonce = new Camera();

        $form = $this->createForm(CameraType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($annonce);
            $manager->flush();
            $this->addFlash(
                'success',
                "L'annonce pour la caméra <strong>{$annonce->getModele()}</strong> a bien été enregistrée."
            );

            return $this->redirectToRoute('annonce_show', [
                'slug' => $annonce->getSlug()
            ]);
        }

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
    public function show(Camera $annonce)
    {

        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce
        ]);
    }

    /**
     * Permet de modifier une annonce existante
     *
     * @Route("/annonce/{slug}/edit", name="annonce_modifier")
     * @return Response
     */
    public function update(Camera $annonce, Request $request, ObjectManager $manager)
    {

        $form = $this->createForm(CameraType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($annonce);
            $manager->flush();
            $this->addFlash(
                'success',
                "Les modifications pour la caméra <strong>{$annonce->getModele()}</strong> ont bien été enregistrées."
            );

            return $this->redirectToRoute('annonce_show', [
                'slug' => $annonce->getSlug()
            ]);
        }

        return $this->render('annonce/modifier.html.twig', [
            'form' => $form->createView(),
            'annonce' => $annonce
        ]);
    }

}