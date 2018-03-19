<?php

declare(strict_types=1);

namespace Dominos\Domain;

class GameDomainService
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
     * @var Board
     */
    private $board;

    /**
     * GameDomainService constructor.
     *
     * @param Stock  $stock
     * @param Player $player1
     * @param Player $player2
     * @param Board  $board
     */
    public function __construct(Stock $stock, Player $player1, Player $player2, Board $board)
    {
        $this->stock = $stock;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->board = $board;
    }

    /**
     * @return Board
     */
    public function init(): Board
    {
        $this->stock->resetAndAdd28Tiles();

        $this->player1->pull7Tiles($this->stock);

        $this->player2->pull7Tiles($this->stock);

        $this->board->addTile($this->stock->pullRandomTile());

        return $this->board;
    }

    /**
     * @param int $i
     *
     * @return Player
     */
    public function determineActivePlayer(int $i): Player
    {
        if (0 === $i % 2) {
            return $this->player1;
        } else {
            return $this->player2;
        }
    }

    /**
     * @param Player $activePlayer
     * @return Tile
     */
    public function playerMakesTurn(Player $activePlayer): Tile
    {
        $tileToPlay = $activePlayer->isThereMatchingTile($this->board);
        if (null === $tileToPlay) {
            $tileToPlay = $this->pullTilesFromStockUntilThereIsMatching($activePlayer);
        }

        return $tileToPlay;
    }

    /**
     * @param Player $activePlayer
     *
     * @return Tile
     */
    private function pullTilesFromStockUntilThereIsMatching(Player $activePlayer): Tile
    {
        do {
            $pulledTile = $this->stock->pullRandomTile();
            $activePlayer->pullTile($pulledTile);
            $matchingTile = $activePlayer->isThereMatchingTile($this->board);

            // @todo: output shouldn't be in domain layer, but nevertheless it should be outputted
            // $this->output->println($activePlayer.' can\'t play, drawing tile '.$pulledTile);

        } while (!$matchingTile instanceof Tile);

        return $matchingTile;
    }

    /**
     * @return Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * @param Tile $tileToAdd
     *
     * @return int
     */
    public function addTile(Tile $tileToAdd): int
    {
        return $this->board->addTile($tileToAdd);
    }
}
