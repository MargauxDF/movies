<?php

declare(strict_types=1);

namespace App\Services;

use hmerritt\Imdb;

class MovieApi
{
    private Imdb $imdb;

    public function __construct(Imdb $imdb)
    {
        $this->imdb = $imdb;
    }

    public function getMovies(string $keyWord, int $nbResults = 10): array
    {
        //Récupérer array des films qui contiennent le keyWord
       $movies = $this->imdb->search($keyWord, [
            'category' => 'tt',
        ]);

        //Récupérer array des détails liés à l'id du film
       for ($i = 0; $i < $nbResults; $i++) {
           $details[] = $this->imdb->film($movies['titles'][$i]['id']);
       }

       //TODO reformater la sortie

        return $details;
    }
}

