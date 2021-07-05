<?php

namespace App\Controller;

use App\Entity\Boat;
use App\Repository\BoatRepository;
use App\Service\MapManagerService;
use Directory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/boat")
 */
class BoatController extends AbstractController
{
    /**
     * Move the boat to coord x,y
     * @Route("/move/{x}/{y}", name="moveBoat", requirements={"x"="\d+", "y"="\d+"}))
     */
    public function moveBoat(int $x, int $y, BoatRepository $boatRepository, EntityManagerInterface $em): Response
    {
        $boat = $boatRepository->findOneBy([]);
        $boat->setCoordX($x);
        $boat->setCoordY($y);
        $em->flush();
        return $this->redirectToRoute('map');
    }
    /**
     * @Route("/direction/{direction}", name="moveDirection", requirements={"direction"="N|E|S|W"})
     */
    public function moveDirection($direction,
    BoatRepository $boatRepository,
    EntityManagerInterface $em,
    MapManagerService $mapManagerService
    ) :Response
    {
        $boat = $boatRepository->findOneBy(['id'=>1]);

        if($direction === 'N') {
            $nord = $boat->getCoordY();
            $direction = $nord -1;
            $boat->setCoordY($direction);
        }
        if($direction === 'S') {
            $sud = $boat->getCoordY();
            $direction = $sud + 1;
            $boat->setCoordY($direction);
        }
        if($direction === 'W') {
            $west = $boat->getCoordX();
            $direction = $west - 1;
            $boat->setCoordX($direction);
        }
        if($direction === 'E') {
            $est = $boat->getCoordX();
            $direction = $est + 1;
            $boat->setCoordX($direction);
        }
        if($mapManagerService->tileExists($boat->getCoordX(),$boat->getCoordY())) {
            $this->addFlash('message','à fond les gaz vas-y');
            $em->flush();
        }else{
            $this->addFlash('message','bateau hors map');
        }
        return $this->redirectToRoute('map');
    }
}
