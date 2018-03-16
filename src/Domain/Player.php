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

    /**
     * @param Stock $stock
     *
     * @return int
     */
    public function pull7Tiles(Stock $stock): int
    {
        for ($i = 0; $i < 7; ++$i) {
            $this->theHand[] = $stock->pullRandomTile();
        }

        return \count($this->theHand);
    }

    /**
     * @param int $number
     * @return Tile|null
     */
    public function isThereMatchingTile(int $number): ?Tile
    {
        foreach ($this->theHand as $key => $tile) {
            if ($tile->isMatching($number)) {
                unset($this->theHand[$key]);
                return $tile;
            }
        }
        return null;
    }
}
