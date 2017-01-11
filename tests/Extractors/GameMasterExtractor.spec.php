<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Tests\Extractors;

use Illuminate\Support\Collection;
use Peridot\Leo\Interfaces\Assert;
use Th3Mouk\PokemonGoIVCalculator\Extractors\GameMasterExtractor;

describe('GameMasterExtractor', function () {
    describe('getGameMasterJson()', function () {
        it("Should return raw array result", function () {
            $raw = (new GameMasterExtractor())->getGameMasterJson();

            $assert = new Assert();

            $assert->isArray($raw);
            $assert->operator(0, '<', count($raw));
        });
    });

    describe('getGameMasterJsonCollection()', function () {
        it("Should return a non empty Illuminate\Collection", function () {
            $collection = (new GameMasterExtractor())->getGameMasterJsonCollection();

            $assert = new Assert();

            $assert->instanceOf($collection, Collection::class);
        });
    });
});
