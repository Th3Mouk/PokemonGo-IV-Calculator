<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Extractors;

use Illuminate\Support\Collection;

class LevelExtractor extends BaseExtractor
{
    private const FILE_PATH = __DIR__.'/../../datas/levels.json';

    protected $json = null;

    /**
     * @var Collection
     */
    protected $collection = null;

    public function getGameMasterJson()
    {
        if (null === $this->json) {
            $this->json = $this->loadJson(self::FILE_PATH);
        }
        return $this->json;
    }

    public function getGameMasterJsonCollection(): Collection
    {
        if (null === $this->collection) {
            $this->collection = new Collection($this->getGameMasterJson());
        }
        return $this->collection;
    }

    public function getDustFiltered(int $dusts)
    {
        return $this->getGameMasterJsonCollection()
            ->where('dust', $dusts);
    }
}
