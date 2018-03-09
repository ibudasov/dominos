<?php

declare(strict_types=1);

namespace Dominos\Domain;

class Stock
{
    /** @var Tile[] */
    private $tiles;

    /**
     * @param Tile $tile
     * @return integer
     */
    public function addTile(Tile $tile): int
    {
        $this->tiles[] = $tile;

        return \count($this->tiles);
    }

    /**
     * @return Tile
     */
    public function pullRandomTile(): Tile
    {
        if (0 === \count($this->tiles)) {
            throw new StockIsEmptyException();
        }

        $randomKey = \array_rand($this->tiles);
        $randomTile = $this->tiles[$randomKey];

        unset($this->tiles[$randomKey]);

        return $randomTile;
    }
}
