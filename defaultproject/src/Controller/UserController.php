<?php

namespace App\Controller;


use App\Entity\User\User1;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class UserController extends AbstractController
{

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param PasswordEncoderInterface $encoder
     * @return Response
     */
    public function register(Request $request,
                             EntityManagerInterface $em,
                             PasswordEncoderInterface $encoder){
        $user = new User1();
        $user->setDateCreated(new \DateTime());
        $registerForm = $this->createForm(RegisterType::class, $user);
        $registerForm->handleRequest($request);
        if($registerForm->isSubmitted() && $registerForm->isValid()){
            $hashed = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashed);

            $em->persist($user);
            $em->flush();

        }

        return $this->render("user/register.html.twig", [
            "registerForm"=>$registerForm->creatView()

        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(){
        return $this->render('user/login.html.twig');
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){

    }
}
