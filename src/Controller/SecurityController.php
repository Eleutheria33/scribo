<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
Use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\RegistrationType;
use App\Form\EditUserType;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $formUser = $this->createForm(RegistrationType::class, $user);

        $formUser->handleRequest($request);

      if ($formUser->isSubmitted() && $formUser->isValid()) {
          dump($formUser);


          $encoded = $encoder->encodePassword($user, $user->getPassword());

          $user->setPassword($encoded);

          !$user->getId() ? $user->setCreateAt(new \DateTime()) : 'null' ;

          $manager->persist($user);
          $manager->flush();

          return $this->redirectToRoute('security_login');
      }

        return $this->render('security/registration.html.twig', [
            'formInscription' => $formUser->createView()
        ]);
    }

    /**
     * @Route("/modification", name="security_edit")
     */
    public function edit(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();
        if (!is_object($user)) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $formUser = $this->createForm(EditUserType::class, $user);

        $formUser->handleRequest($request);

      if ($formUser->isSubmitted() && $formUser->isValid()) {
          $encoded = $encoder->encodePassword($user, $user->getPassword());
          $user->setPassword($encoded);

          $manager->flush();

          return $this->redirectToRoute('security_login');
      }

        return $this->render('security/editUser.html.twig', [
            'formEdit' => $formUser->createView()
        ]);
    }


    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
     {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);


    }

    /**
     * @Route("/Déconnexion", name="security_logout")
     */
    public function logout(){}

}
