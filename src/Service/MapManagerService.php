<?php

namespace App\Service;

use App\Entity\Tile;
use App\Repository\TileRepository;
use Doctrine\ORM\EntityManagerInterface;

class MapManagerService
{
    private $tileRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->tileRepository = $em->getRepository(Tile::class);
    }

    public function tileExists(int $x,int $y): bool
    {
        $tiles = $this->tileRepository->findOneBy([]);
        if($x<0 || $x>11 || $y<0 || $y>5){
            return false;
        } else {
            return true;
        }
    }
    public function getRandomIsland(TileRepository $tileRepository)
    {
        $island = $tileRepository->findBy(['type'=>'island']);
        return $islandRandom = array_rand($island,1);
    }
}