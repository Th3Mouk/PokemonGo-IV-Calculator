<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Extractors;

use Illuminate\Support\Collection;

class GameMasterExtractor extends BaseExtractor
{
    private const FILE_PATH = __DIR__.'/../../datas/gamemaster.json';

    protected $json = null;

    /**
     * @var Collection
     */
    protected $collection = null;

    public function getGameMasterJson()
    {
        if (null === $this->json) {
            $this->json = $this->loadJson(self::FILE_PATH)->itemTemplates;
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
}
