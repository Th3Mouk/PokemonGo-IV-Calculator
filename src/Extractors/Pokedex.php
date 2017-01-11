<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Extractors;

use Th3Mouk\PokemonGoIVCalculator\Entities\Pokemon;
use Th3Mouk\PokemonGoIVCalculator\Exceptions\PokemonNotFound;

class Pokedex extends GameMasterExtractor
{
    /**
     * Retrieve a Pokemon object from GameMaster file
     * @param  string          $name
     * @throws PokemonNotFound
     * @return Pokemon
     */
    public function get($name): Pokemon
    {
        $collection = $this->getGameMasterJsonCollection();

        $finded = $collection
            ->filter(function ($line) {
                if (isset($line->pokemonSettings)) {
                    return true;
                }
                return false;
            })
            ->filter(function ($line) use ($name) {
                return $line->pokemonSettings->pokemonId === strtoupper($name);
            })
            ->first()
        ;

        if (null === $finded) {
            throw new PokemonNotFound(strtolower($name));
        }

        return $this->morph($finded);
    }

    /**
     * Transform raw datas from GameMaster file to Pokemon Object
     * @param $pokemon
     * @return Pokemon
     */
    private function morph($pokemon)
    {
        return new Pokemon(
            strtolower($pokemon->pokemonSettings->pokemonId),
            $pokemon->pokemonSettings->stats->baseAttack,
            $pokemon->pokemonSettings->stats->baseDefense,
            $pokemon->pokemonSettings->stats->baseStamina
        );
    }
}
