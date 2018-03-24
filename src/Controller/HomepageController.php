<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Tournament;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request): Response
    {
        $tournaments = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Tournament::class)
            ->findAll();

        return $this->render('homepage.html.twig', [
            'tournaments' => $tournaments,
            'message' => $request->query->get('message', 'Pas de message')
        ]);
    }
}
