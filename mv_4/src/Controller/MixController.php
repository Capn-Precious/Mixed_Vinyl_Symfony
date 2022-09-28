<?php

namespace App\Controller;

use App\Entity\VinylMix;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MixController extends AbstractController
{
    #[Route('/mix/new')]
    public function new(): Response
    {
        $mix = new VinylMix();
        $mix->setTitle('Who is Phil Collins?');
        $mix->setDescription('drummers turned singers');
        $mix->setGenre('pop');
        $mix->setTrackCount(rand(5, 30));
        $mix->setVotes(rand(-50, 50));
        dd($mix);
    }

}
