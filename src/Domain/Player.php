<?php

declare(strict_types=1);

namespace Dominos\Domain;
use Dominos\Domain\Tile;

class Player {

    /**
     * @var Tile[]
     */
    private $theHand;

    /**
     * @param Tile $tile
     * @return integer
     */
    public function pullTile(Tile $tile): int {
        $this->theHand[] = $tile;

        return \count($this->theHand);
    }
}