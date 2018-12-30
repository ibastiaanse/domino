<?php
declare(strict_types=1);

namespace Domino;

class Tile
{
    /**
     * @var string
     */
    private $sideA;

    /**
     * @var string
     */
    private $sideB;

    /**
     * @var array
     */
    private $availableSide;

    /**
     * @var string
     */
    private $defaultColor = "\033[39;0m";

    /**
     * @var string
     */
    private $color;

    public function __construct(string $sideA, string $sideB)
    {
        $this->sideA = $sideA;
        $this->sideB = $sideB;
    }

    public function getSideA(): string
    {
        return $this->sideA;
    }

    public function getSideB(): string
    {
        return $this->sideB;
    }

    public function turnTile(): void
    {
        $sideA = $this->sideA;
        $sideB = $this->sideB;

        $this->sideA = $sideB;
        $this->sideB = $sideA;
    }

    public function addColor(string $color): void
    {
        $this->color = $color;
    }

    public function __toString(): string
    {
        return "$this->color[ $this->sideA | $this->sideB ]$this->defaultColor";
    }
}
