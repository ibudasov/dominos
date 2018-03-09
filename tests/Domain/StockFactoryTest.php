<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Dominos\Domain\StockFactory;
use Dominos\Domain\Stock;

class StockFactoryTest extends TestCase
{
    public function testThatStockCanBeCreated(): void
    {
        $stock = StockFactory::createStockWith28Tiles();

        self::assertInstanceOf(Stock::class, $stock);
    }
}
