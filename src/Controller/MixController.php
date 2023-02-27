<?php
/**
 *
 * There are 4 different arguments you can have on a controller method
 * - Route wildcards
 * - Auto wire Services
 * - Type hint Entities
 * - Type hint Request Class
 */
namespace App\Controller;

use App\Entity\VinylMix;
use App\Repository\VinylMixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MixController extends AbstractController
{
    #[Route('/mix/new')]
    public function new(EntityManagerInterface $entityManager):Response{
        $mix = new VinylMix();
        $mix->setTitle('Do you Remember... Phil Collins?!');
        $mix->setDescription('A pure mix of drummers turned singers!');
        $genres = ['pop','rock'];
        $mix->setGenre($genres[array_rand($genres)]);
        $mix->setTrackCount(rand(5, 20));
        $mix->setVotes(rand(-50, 50));

        $entityManager->persist($mix);
        $entityManager->flush();

        return new Response(sprintf(
            "Mix %d is %d tracks of pure 80's heaven!",
                $mix->getId(),
                $mix->getTrackCount()
        ));
    }
    #[Route('/mix/{id}',name:'app_mix_show')]

//    public function show(int $id, VinylMixRepository $vinylMixRepository):Response{
    /* This works on 6.2, On versions < 6.2, run 'composer require sensio/framework-extra-bundle' */
    public function show(VinylMix $mix):Response{
        // slug-name must match Query name ie: (id => $id)
        // use for querying single item, otherwise inject Repository Service

        return $this->render('mix/show.html.twig',[
            'mix'=>$mix
        ]);
    }
    #[Route('/mix/{id}/vote', name: 'app_mix_vote', methods: 'POST')]
    public function vote(VinylMix $mix,Request $request, EntityManagerInterface $entityManager):Response{

        $direction = $request->request->get('direction', 'up');

        $direction === 'up' ? $mix->upVote() : $mix->downVote();


        /* We only need persist on new objects */
        //$entityManager->persist($mix);
        $entityManager->flush();

        $this->addFlash('success', 'Vote added!');

        return $this->redirectToRoute('app_mix_show',[
           'id'=> $mix->getId()
        ]);

    }

}