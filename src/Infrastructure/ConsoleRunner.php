<?php

declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use Dominos\Application\Game;
use Dominos\Domain\Board;
use Dominos\Domain\GameDomainService;
use Dominos\Domain\Player;
use Dominos\Domain\Stock;
use Dominos\Infrastructure\ConsoleOutput;

/**
 * @codeCoverageIgnore -- infrastructure level is not meant to be tested
 */
class ConsoleRunner
{
    public static function run(): void
    {
        $stock = new Stock();
        $player1 = new Player('👨 Igor');
        $player2 = new Player('💁 Kate');
        $board = new Board();
        $output = new ConsoleOutput();

        $gameService = new GameDomainService($stock, $player1, $player2, $board);
        $game = new Game($gameService, $output);
        $game->run();
    }
}
