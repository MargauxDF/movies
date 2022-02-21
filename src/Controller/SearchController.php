<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use hmerritt\Imdb;


class SearchController extends AbstractController
{
    #[Route('/', name: 'search_film')]
    public function search(Request $request): Response
    {
        $imdb = new Imdb();

        $form = $this->createFormBuilder()
            ->add('search', TextType::class, [
                'label' => false,
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            //Searching for list of films which contain the string
            $films = $imdb->search($data['search'], [
                'category' => 'tt',
            ]);

            //Getting all the infos of the films in the list (only 10 first results)
            foreach (array_slice($films['titles'], 0, 10) as $film) {
                $details[] = $imdb->film($film['id']);
            }
        }

        if (!isset($details)) {
            return $this->render('search/index.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
            'details' => $details,
        ]);
    }
}
