<?php

declare(strict_types=1);

namespace Dominos\Domain;

class Stock
{
    /** @var Tile[] */
    private $tiles;

    public function __construct()
    {
        $tileValues = [
            [0, 1], [0, 2], [0, 3], [0, 4], [0, 5], [0, 6], [1, 2], [1, 3], [1, 4], [1, 5], [1, 6], [2, 3], [2, 4], [2, 5], [2, 6], [3, 4], [3, 5], [3, 6], [4, 5], [4, 6], [5, 6], [0, 0], [1, 1], [2, 2], [3, 3], [4, 4], [5, 5], [6, 6],
        ];

        foreach ($tileValues as $tileValue) {
            $this->tiles[] = new Tile($tileValue[0], $tileValue[1]);
        }
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
