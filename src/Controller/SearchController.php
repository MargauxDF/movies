<?php

namespace App\Controller;

use App\Services\MovieApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use hmerritt\Imdb;


class SearchController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(Request $request, MovieApi $movieApi): Response
    {
        //simplifier formulaire
        $form = $this->createFormBuilder()
            ->add('search', TextType::class, [
                'label' => false,
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $movies = $movieApi->getMovies($data['search']);
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
            'movies' => $movies ?? [],
        ]);
    }
}
