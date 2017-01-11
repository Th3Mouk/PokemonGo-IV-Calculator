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
    describe('get(pikachu)', function () {
        it("Should return a pokemon object of Pikachu", function () {
            $pokemon = (new Pokedex())->get('pikachu');

            $assert = new Assert();

            $assert->strictEqual($pokemon->getName(), 'pikachu');
            $assert->isInteger($pokemon->getBaseAttack());
            $assert->isInteger($pokemon->getBaseDefense());
            $assert->isInteger($pokemon->getBaseStamina());
        });
    });

    describe('get(unknowedPkm)', function () {
        it("Should throws a PokemonNotFound exception", function () {
            $assert = new Assert();

            $assert->throws(function () {
                (new Pokedex())->get('unknowedPkm');
            }, PokemonNotFound::class);
        });
    });
});
