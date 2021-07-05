<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tile;
use App\Repository\BoatRepository;
use Doctrine\ORM\EntityManagerInterface;

class MapController extends AbstractController
{
    /**
     * @Route("/map", name="map")
     */
    public function displayMap(BoatRepository $boatRepository): Response
    {
        $boat = $boatRepository->findOneBy(['id'=>1]);
        $positionX = $boat->getCoordX();
        $positionY = $boat->getCoordY();
        $boatName = $boat->getName();
        $em = $this->getDoctrine()->getManager();
        $tiles = $em->getRepository(Tile::class)->findAll();

        foreach ($tiles as $tile) {
            $map[$tile->getCoordX()][$tile->getCoordY()] = $tile;
        }

        $boat = $boatRepository->findOneBy([]);

        return $this->render('map/index.html.twig', [
            'map'  => $map ?? [],
            'boat' => $boat,
            'positionx' => $positionX,
            'positiony' => $positionY,
            'boatName'  => $boatName
        ]);
    }
    
    /**
     * @Route("/start", name="start_game")
     */
    public function start(BoatRepository $boatRepository, EntityManagerInterface $em)
    {
        $boat = $boatRepository->findOneBy(['id'=>1]);
        $boat->setCoordX(0)->setCoordY(0);
        $em->flush();

        return $this->redirectToRoute('map');
    }
}
