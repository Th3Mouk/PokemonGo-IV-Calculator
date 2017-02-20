<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Tests\Calculator;

use Peridot\Leo\Interfaces\Assert;
use Th3Mouk\PokemonGoIVCalculator\Calculator\Helpers;

describe('Helpers', function () {
    beforeEach(function () {
        $this->assert = new Assert();
    });

    context('dustsToMax', function () {
        it("results must be asserted", function () {
            $this->assert->equal(
                Helpers::dustsToMax(1, 3),
                2000
            );

            $this->assert->equal(
                Helpers::dustsToMax(10, 10),
                3300
            );

            $this->assert->equal(
                Helpers::dustsToMax(20.5, 20),
                5500
            );

            $this->assert->equal(
                Helpers::dustsToMax(21, 20),
                3000
            );

            $this->assert->equal(
                Helpers::dustsToMax(21.5, 20),
                0
            );
        });
    });

    context('candiesToMax', function () {
        it("results must be asserted", function () {
            $this->assert->equal(
                Helpers::candiesToMax(1, 3),
                7
            );

            $this->assert->equal(
                Helpers::candiesToMax(10, 10),
                4
            );

            $this->assert->equal(
                Helpers::candiesToMax(20.5, 20),
                5
            );

            $this->assert->equal(
                Helpers::candiesToMax(21, 20),
                3
            );

            $this->assert->equal(
                Helpers::candiesToMax(21.5, 20),
                0
            );
        });
    });
});
