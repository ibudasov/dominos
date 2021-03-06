<?php

declare(strict_types=1);

namespace Dominos\Domain;

class Tile
{
    /** @var int */
    private $firstValue;
    /** @var int */
    private $secondValue;

    /**
     * @param int $firstValue
     * @param int $secondValue
     */
    public function __construct(int $firstValue, int $secondValue)
    {
        $this->firstValue = $firstValue;
        $this->secondValue = $secondValue;
    }

    /**
     * @return int
     */
    public function getFirstValue(): int
    {
        return $this->firstValue;
    }

    /**
     * @return int
     */
    public function getSecondValue(): int
    {
        return $this->secondValue;
    }

    /**
     * @param int $number
     *
     * @return bool
     */
    public function isMatching(int $number): bool
    {
        return
            $this->getFirstValue() === $number
            ||
            $this->getSecondValue() === $number
        ;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return '<'.$this->firstValue.':'.$this->secondValue.'>';
    }
}
