<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Tournament;
use App\Entity\Game;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request): Response
    {
        $tournaments = $this
            ->getDoctrine()
            ->getRepository(Tournament::class)
            ->findAll();

        return $this->render('homepage.html.twig', [
            'tournaments' => $tournaments
        ]);
    }

    /**
     * @Route("/tournament", name="tournament")
     */
    public function tournament(Request $request): Response
    {
        $tournament = $this
            ->getDoctrine()
            ->getRepository(Tournament::class)
            ->find($request->query->get('id'));

        return $this->render('tournament.html.twig', [
            'tournament' => $tournament
        ]);
    }

    /**
     * @Route("/match/add", name="addMatch")
     */
    public function addMatch(Request $request): Response
    {
        $url = $this->generateUrl('homepage');

        if ($request->getMethod() === 'POST') {
            $game = new Game();

            $game->nameTeam1  = $request->request->get('nameTeam1');
            $game->nameTeam2 = $request->request->get('nameTeam2');

            $game->scoreTeam1 = 0;
            $game->scoreTeam2 = 0;

            $tournament = $this
                ->getDoctrine()
                ->getRepository(Tournament::class)
                ->find($request->request->get('tournament'));

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($game);
            $entityManager->flush();

            $arrayMatchs = array();
            $arrayMatchs[] = $game;

            foreach ($tournament->matchs as $match)
            {
                $arrayMatchs[] = $match;
            }

            $tournament->matchs = $arrayMatchs;

            $entityManager->persist($tournament);
            $entityManager->flush();

            $url = $this->generateUrl('tournament', ['id' => $tournament->id]);
        }

        return $this->redirect($url);
    }

    /**
     * @Route("/match/update", name="updateMatch")
     */
    public function updateMatch(Request $request): Response
    {
        $url = $this->generateUrl('homepage');

        if ($request->getMethod() === 'POST') {
            $game = $this
                ->getDoctrine()
                ->getRepository(Game::class)
                ->find($request->request->get('match'));

            $game->scoreTeam1 = (int) $request->request->get('scoreTeam1');
            $game->scoreTeam2 = (int) $request->request->get('scoreTeam2');

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($game);
            $entityManager->flush();
            $url = $this->generateUrl('tournament', ['id' => $request->request->get('tournament')]);
        }

        return $this->redirect($url);
    }

    /**
     * @Route("/match/delete", name="deleteMatch")
     */
    public function deleteMatch(Request $request): Response
    {
        $url = $this->generateUrl('homepage');

        if ($request->getMethod() === 'POST') {
            $idMatch = (int) $request->request->get('match');

            $tournament = $this
                ->getDoctrine()
                ->getRepository(Tournament::class)
                ->find($request->request->get('tournament'));

            $arrayMatchs = array();

            foreach ($tournament->matchs as $match)
            {
                if ($match->id !== $idMatch)
                {
                    $arrayMatchs[] = $match;
                }
            }

            $tournament->matchs = $arrayMatchs;

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($tournament);
            $entityManager->flush();
            $url = $this->generateUrl('tournament', ['id' => $request->request->get('tournament')]);
        }

        return $this->redirect($url);
    }
}