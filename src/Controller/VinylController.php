<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;


class VinylController extends AbstractController
{
    #[Route(path: '/',name: 'app_homepage')]
    public function homepage():Response{

        /** @var TYPE_NAME $tracks */
        $tracks = [
            ['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
            ['song' => 'Waterfalls', 'artist' => 'TLC'],
            ['song' => 'Creep', 'artist' => 'Radiohead'],
            ['song' => 'Kiss from a Rose', 'artist' => 'Seal'],
            ['song' => 'On Bended Knee', 'artist' => 'Boyz II Men'],
            ['song' => 'Fantasy', 'artist' => 'Mariah Carey'],
        ];

        /* return Response */
        return $this->render( 'vinyl/homepage.html.twig',[
            'title'=> 'PB and jams',
            'tracks'=> $tracks
        ]);
    }

    #[Route('/browse/{slug}',name:'app_browse')]
    public function browse(string $slug = null):Response{

        /* If a slug is provided, set the $genre, otherwise set it to null */
        $genre = ($slug) ? 'Genre: '.u(str_replace('-',' ',$slug))->title(true) : null ;

        /* return Response */
        return $this->render('vinyl/browse.html.twig',['genre' => $genre]);

    }
}
