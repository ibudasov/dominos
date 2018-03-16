<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use Dominos\Application\Game;
use Dominos\Domain\Board;
use Dominos\Domain\Player;
use Dominos\Domain\Stock;

/**
 * @codeCoverageIgnore -- infrastructure level is not meant to be tested
 */
class ConsoleRunner
{
    public static function run(): void
    {
        $stock = new Stock();
        $player1 = new Player();
        $player2 = new Player();
        $board = new Board();

        $game =  new Game($stock, $player1, $player2, $board);
        $game->run();
    }
}
