<?php

namespace App\Controller;

use App\Entity\Loueur;
use App\Entity\PasswordUpdate;
use App\Form\AccountType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * Permet la connexion
     *
     * @Route("/login", name="account_login")
     *
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
    ]);
    }

    /**
     * Permet la déconnexion
     *
     * @Route("/logout", name="account_logout")
     *
     * @return void_
     */
    public function logout(){

    }

    /**
     * Permet de s'inscrire
     *
     * @Route("/register", name="account_register")
     *
     * @return Response
     *
     */
    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $loueur = new Loueur();

        $form = $this->createForm(RegistrationType::class, $loueur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($loueur, $loueur->getHash());
            $loueur->setHash($hash);

            $manager->persist($loueur);
            $manager->flush();

            $this->addFlash(
                'success',
                "Félicitations!<br>Votre compte a été créé.<br>Vous pouvez maintenant vous connecter."
            );
            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier son profil
     *
     * @Route("/account/profile", name="account_profile")
     *
     * @return Response
     */
    public function profile(Request $request, ObjectManager $manager)
    {
        $loueur = $this->getUser();

        $form = $this->createForm(AccountType::class, $loueur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($loueur);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les modifications ont été prises en compte."
            );
        }

        return $this->render('account/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier le mot de passe
     *
     * @Route("/account/password-update", name="account_password")
     *
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager)
    {
        $passwordUpdate = new PasswordUpdate();

        $loueur = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!password_verify($passwordUpdate->getOldPassword(), $loueur->getHash())){
                //Erreur
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->isPasswordValid($loueur, $newPassword);

                $loueur->setHash($hash);

                $manager->persist($loueur);
                $manager->flush();

                $this->addFlash(

                    'success',
                    "Le mot de passe a bien été modifié."
                );

                return $this->redirectToRoute('accueil');
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
