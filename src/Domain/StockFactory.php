<?php

declare(strict_types=1);

namespace Dominos\Domain;

class StockFactory
{
    public static function createStockWith28Tiles(): Stock
    {
        $tileValues = [
            [0, 1], [0, 2], [0, 3], [0, 4], [0, 5], [0, 6], [1, 2], [1, 3], [1, 4], [1, 5], [1, 6], [2, 3], [2, 4], [2, 5], [2, 6], [3, 4], [3, 5], [3, 6], [4, 5], [4, 6], [5, 6], [0, 0], [1, 1], [2, 2], [3, 3], [4, 4], [5, 5], [6, 6],
        ];

        $stock = new Stock();

        foreach ($tileValues as $tileValue) {
            $stock->addTile(new Tile($tileValue[0], $tileValue[1]));
        }

        return $stock;
    }
}