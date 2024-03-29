<?php

namespace App\Controller;

use App\Entity\VinylMix;
use App\Repository\VinylMixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MixController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/mix/new', name: 'app_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {

        $mix = new VinylMix();
        $mix->setTitle('Who is Phil Collins?');
        $mix->setDescription('drummers turned singers');
        $genres = ['pop', 'rock'];
        $mix->setGenre($genres[array_rand($genres)]);
        $mix->setTrackCount(random_int(5, 30));
        $mix->setVotes(random_int(-50, 50));

        $entityManager->persist($mix);
        $entityManager->flush();

        return new Response(sprintf(
            'Mis %d is %d tracks of pure 80\'s heaven ',
            $mix->getId(),
            $mix->getTrackCount()
        ));
    }

    #[Route('/mix/{slug}', name: 'app_mix_show')]
    public function show(VinylMix $mix): Response
    {
        return $this->render('mix/show.html.twig', [
            'mix' => $mix
        ]);
    }

    #[Route('/mix/{id}/vote', name: 'app_mix_vote', methods: ['POST'])]
    public function vote(VinylMix $mix, Request $request, EntityManagerInterface $entityManager): Response
    {
        $direction = $request->request->get('direction', 'up');

        if($direction === 'up')
        {
            $mix->upVote();
        } else {
            $mix->downvote();
        }

        $entityManager->flush();

        $this->addFlash('success', 'Vote Counted!');

        return $this->redirectToRoute('app_mix_show', [
            'slug' => $mix->getSlug(),
        ]);
    }
}
