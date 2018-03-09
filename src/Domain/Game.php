<?php

declare(strict_types=1);

namespace Dominos\Domain;

class Game
{
    /**
     * @var Stock
     */
    private $stock;
    /**
     * @var Player
     */
    private $player1;
    /**
     * @var Player
     */
    private $player2;

    /**
     * @param Stock  $stock
     * @param Player $player1
     * @param Player $player2
     */
    public function __construct(Stock $stock, Player $player1, Player $player2)
    {
        $this->stock = $stock;
        $this->player1 = $player1;
        $this->player2 = $player2;
    }

    /**
     * @return int
     */
    public function player1Pulls7Tiles(): int
    {
        $this->player1->pullTile($this->stock->pullRandomTile());
        $this->player1->pullTile($this->stock->pullRandomTile());
        $this->player1->pullTile($this->stock->pullRandomTile());
        $this->player1->pullTile($this->stock->pullRandomTile());
        $this->player1->pullTile($this->stock->pullRandomTile());
        $this->player1->pullTile($this->stock->pullRandomTile());

        return $this->player1->pullTile($this->stock->pullRandomTile());
    }

    /**
     * @return int
     */
    public function player2Pulls7Tiles(): int
    {
        $this->player2->pullTile($this->stock->pullRandomTile());
        $this->player2->pullTile($this->stock->pullRandomTile());
        $this->player2->pullTile($this->stock->pullRandomTile());
        $this->player2->pullTile($this->stock->pullRandomTile());
        $this->player2->pullTile($this->stock->pullRandomTile());
        $this->player2->pullTile($this->stock->pullRandomTile());

        return $this->player2->pullTile($this->stock->pullRandomTile());
    }
}
