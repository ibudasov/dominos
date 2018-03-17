<?php

declare(strict_types=1);

namespace Dominos\Application;

use Dominos\Domain\Board;
use Dominos\Domain\Output;
use Dominos\Domain\Player;
use Dominos\Domain\PlayerIsOutOfTilesException;
use Dominos\Domain\Stock;
use Dominos\Domain\StockIsEmptyException;
use Dominos\Domain\Tile;

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
     * @var Board
     */
    private $board;
    /**
     * @var Output
     */
    private $output;

    /**
     * @param Stock  $stock
     * @param Player $player1
     * @param Player $player2
     * @param Board  $board
     * @param Output $output
     */
    public function __construct(Stock $stock, Player $player1, Player $player2, Board $board, Output $output)
    {
        $this->stock = $stock;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->board = $board;
        $this->output = $output;
    }

    public function run(): void
    {
        $this->stock->resetAndAdd28Tiles();

        $this->player1->pull7Tiles($this->stock);

        $this->player2->pull7Tiles($this->stock);

        $firstTile = $this->stock->pullRandomTile();

        $this->board->addTile($firstTile);

        $this->output->println('Game starting with first tile: '.$firstTile);

        try {
            for ($i = 0; $i < 28; ++$i) {
                $activePlayer = $this->determineActiveUser($i);

                $tileToPlay = $this->getTileFromTheHandOrPullFromStock($activePlayer);

                $this->board->addTile($tileToPlay);

                $this->output->println($activePlayer.' plays '.$tileToPlay);
                $this->output->println('Board is now: '.$this->board);
            }
        } catch (PlayerIsOutOfTilesException $exception) {
            $this->output->println($activePlayer.' has won!');
            exit;
        } catch (StockIsEmptyException $exception) {
            $this->output->println('Game over. Nobody wins.');
            exit;
        }
    }

    /**
     * @param int $i
     *
     * @return Player
     */
    public function determineActiveUser(int $i): Player
    {
        if (0 === $i % 2) {
            return $this->player1;
        } else {
            return $this->player2;
        }
    }

    /**
     * @param Player $activePlayer
     *
     * @return Tile
     */
    private function getTileFromTheHandOrPullFromStock(Player $activePlayer): Tile
    {
        $tileToPlay = $activePlayer->isThereMatchingTile($this->board);
        if (!$tileToPlay instanceof Tile) {
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

            $this->output->println($activePlayer.' can\'t play, drawing tile '.$pulledTile);
        } while (!$matchingTile instanceof Tile);

        return $matchingTile;
    }
}
