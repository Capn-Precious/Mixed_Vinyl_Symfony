<?php

namespace App\Controller;

use App\Entity\VinylMix;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MixController extends AbstractController
{
    #[Route('/mix/new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $mix = new VinylMix();
        $mix->setTitle('Who is Phil Collins?');
        $mix->setDescription('drummers turned singers');
        $mix->setGenre('pop');
        $mix->setTrackCount(rand(5, 30));
        $mix->setVotes(rand(-50, 50));

        $entityManager->persist($mix);
        $entityManager->flush();

        return new Response(sprintf(
            'Mis %d is %d tracks of pure 80\'s heaven ',
            $mix->getId(),
            $mix->getTrackCount()
        ));
    }
}