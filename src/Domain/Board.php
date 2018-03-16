<?php

declare(strict_types=1);

namespace Dominos\Domain;

class Board
{
    /** @var array */
    private $tiles;
    /** @var int */
    private $leadingNumber;
    /** @var int */
    private $trailingNumber;

    public function __construct()
    {
        $this->tiles = [];
        $this->leadingNumber = 0;
        $this->trailingNumber = 0;
    }

    public function addTile(Tile $tile): int
    {
        $this->setLeadingAndTrailingNumberWhenBoardsIsEmpty($tile);

        $this->updateLeadingNumber($tile);

        $this->updateTrailingNumber($tile);

        $this->addTileToTheStackInProperOrder($tile);

        return \count($this->tiles);
    }

    public function getLeadingNumber(): int
    {
        return $this->leadingNumber;
    }

    public function getTrailingNumber(): int
    {
        return $this->trailingNumber;
    }

    /**
     * @param Tile $tile
     */
    private function setLeadingAndTrailingNumberWhenBoardsIsEmpty(Tile $tile): void
    {
        if (0 === \count($this->tiles)) {
            $this->leadingNumber = $tile->getFirstValue();
            $this->trailingNumber = $tile->getSecondValue();
        }
    }

    /**
     * @param Tile $tile
     */
    private function updateLeadingNumber(Tile $tile): void
    {
        $this->leadingNumber = ($tile->getSecondValue() === $this->leadingNumber)
            ? $tile->getFirstValue()
            : $this->leadingNumber;
    }

    /**
     * @param Tile $tile
     */
    private function updateTrailingNumber(Tile $tile): void
    {
        $this->trailingNumber = ($tile->getFirstValue() === $this->trailingNumber)
            ? $tile->getSecondValue()
            : $this->trailingNumber;
    }

    public function __toString(): string
    {
        $result = '';
        foreach ($this->tiles as $tile) {
            $result .= $tile.' ';
        }

        return $result;
    }

    /**
     * @param Tile $tile
     */
    public function addTileToTheStackInProperOrder(Tile $tile): void
    {
        if ($tile->getFirstValue() === $this->trailingNumber || $tile->getSecondValue() === $this->trailingNumber) {
            \array_push($this->tiles, $tile);
        } else {
            \array_unshift($this->tiles, $tile);
        }
    }
}
