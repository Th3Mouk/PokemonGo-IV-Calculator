<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Tests\Extractors;

use Peridot\Leo\Interfaces\Assert;
use Th3Mouk\PokemonGoIVCalculator\Exceptions\PokemonNotFound;
use Th3Mouk\PokemonGoIVCalculator\Extractors\Pokedex;

describe('Pokedex', function () {
    it("Should return a pokemon object of Pikachu", function () {
        $pokemon = (new Pokedex())->get('pikachu');

        $assert = new Assert();

        $assert->isInteger($pokemon->getNumber());
        $assert->equal($pokemon->getNumber(), 25);
        $assert->strictEqual($pokemon->getName(), 'pikachu');
        $assert->isInteger($pokemon->getBaseAttack());
        $assert->isInteger($pokemon->getBaseDefense());
        $assert->isInteger($pokemon->getBaseStamina());

        $assert->equal($pokemon->getTypes(), ['POKEMON_TYPE_ELECTRIC']);
    });

    it("Should return a clefairy family", function () {
        $pokemons = (new Pokedex())->getByFamily('family_clefairy');

        $assert = new Assert();

        $assert->equal($pokemons->count(), 3);

        foreach ($pokemons as $pokemon) {
            $assert->equal($pokemon->getFamilyId(), 'FAMILY_CLEFAIRY');
        }
    });

    it("Should return a pokemon object of Gyarados", function () {
        $pokemon = (new Pokedex())->get('Gyarados');

        $assert = new Assert();

        $assert->isInteger($pokemon->getNumber());
        $assert->equal($pokemon->getNumber(), 130);
        $assert->strictEqual($pokemon->getName(), 'gyarados');
        $assert->isInteger($pokemon->getBaseAttack());
        $assert->isInteger($pokemon->getBaseDefense());
        $assert->isInteger($pokemon->getBaseStamina());

        $assert->equal($pokemon->getTypes(),
            ['POKEMON_TYPE_WATER', 'POKEMON_TYPE_FLYING']
        );
    });

    it("Should throws a PokemonNotFound exception", function () {
        $assert = new Assert();

        $assert->throws(function () {
            (new Pokedex())->get('unknowedPkm');
        }, PokemonNotFound::class);
    });
});
