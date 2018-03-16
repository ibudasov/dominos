<?php

declare(strict_types=1);

namespace Dominos\Domain;

class Board
{
    /** @var array */
    private $tiles;

    public function __construct()
    {
        $this->tiles = [];
    }

    public function addTile(Tile $tile): int
    {
        $this->tiles[] = $tile;

        return \count($this->tiles);
    }
}
