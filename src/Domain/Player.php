<?php

declare(strict_types=1);

namespace Dominos\Domain;

use Dominos\Domain\Stock;

class Player
{
    /**
     * @var Tile[]
     */
    private $theHand;

    /**
     * @param Tile $tile
     *
     * @return int
     */
    public function pullTile(Tile $tile): int
    {
        $this->theHand[] = $tile;

        return \count($this->theHand);
    }

    /**
     * @param Stock $stock
     * @return integer
     */
    public function pull7Tiles(Stock $stock): int {
        for($i=0; $i<7; $i++) {
            $this->theHand[] = $stock->pullRandomTile();
        }

        return \count($this->theHand);        
    }
}
