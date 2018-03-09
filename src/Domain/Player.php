<?php

declare(strict_types=1);

namespace Dominos\Domain;

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
}
