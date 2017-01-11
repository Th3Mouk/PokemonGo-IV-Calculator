<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Tests\Extractors;

use Illuminate\Support\Collection;
use Peridot\Leo\Interfaces\Assert;
use Th3Mouk\PokemonGoIVCalculator\Extractors\LevelExtractor;

describe('LevelExtractor', function () {
    describe('getGameMasterJson()', function () {
        it("Should return raw array result", function () {
            $raw = (new LevelExtractor())->getGameMasterJson();

            $assert = new Assert();

            $assert->isArray($raw);
            $assert->operator(0, '<', count($raw));
        });
    });

    describe('getGameMasterJsonCollection()', function () {
        it("Should return a non empty Illuminate\Collection", function () {
            $collection = (new LevelExtractor())->getGameMasterJsonCollection();

            $assert = new Assert();

            $assert->instanceOf($collection, Collection::class);
        });
    });

    describe('getDustFiltered(200)', function () {
        it("Should return a non empty Illuminate\Collection", function () {
            $collection = (new LevelExtractor())->getDustFiltered(200);

            $assert = new Assert();

            $assert->instanceOf($collection, Collection::class);
        });
    });

    describe('getDustFiltered(1)', function () {
        it("Should return an empty Illuminate\Collection", function () {
            $collection = (new LevelExtractor())->getDustFiltered(1);

            $assert = new Assert();

            $assert->instanceOf($collection, Collection::class);
            $assert->lengthOf($collection, 0);
        });
    });
});
