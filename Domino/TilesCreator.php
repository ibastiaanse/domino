<?php
declare(strict_types=1);

namespace Domino;

class TilesCreator
{
    /**
     * @var array
     */
    private $endings = [
        0 => ' ',
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        6 => '6',
    ];

    /**
     * @var Tiles
     */
    private $tiles;

    public function __construct(Tiles $tiles)
    {
        $this->tiles = $tiles;
    }

    public function createNewSet(): Tiles
    {
        foreach ($this->endings as $valueA => $sideA) {
            $this->addTile($valueA, $sideA);
        }

        return $this->tiles;
    }

    private function addTile(int $valueA, string $sideA): void
    {
        foreach ($this->endings as $valueB => $sideB) {
            if ($valueA > $valueB) {
                continue;
            }

            $tile = new Tile($sideA, $sideB);

            $this->tiles->addTile($tile);
        }
    }
}
