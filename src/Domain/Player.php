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
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

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
     *
     * @throws PlayerIsOutOfTilesException
     *
     * @return Tile|null
     */
    public function isThereMatchingTile(int $number): ?Tile
    {
        if (empty($this->theHand)) {
            throw new PlayerIsOutOfTilesException();
        }

        foreach ($this->theHand as $key => $tile) {
            if ($tile->isMatching($number)) {
                unset($this->theHand[$key]);

                return $tile;
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
