<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SongAPIController extends AbstractController
{

    #[Route(path: '/api/v1/songs/{id<\d+>}' /* Digit of any length */,name:'app_song',methods: ['GET'])]
    public function getSong(int $id = null, LoggerInterface $logger):Response{

        // TODO query the database
        $song = [
            'id' => $id,
            'name' => 'Waterfalls',
            'url' => 'https://symfonycasts.s3.amazonaws.com/sample.mp3',
        ];

        $logger->info("Returning info for song: {song}",[
            'song' => $id
        ]);
        return $this->json($song);
    }
}