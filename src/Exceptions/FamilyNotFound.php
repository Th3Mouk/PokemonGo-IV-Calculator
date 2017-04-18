<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Exceptions;

class FamilyNotFound extends NotFound
{
    public function __construct($family)
    {
        parent::__construct(ucfirst($family).' family doesn\'t exists');
    }
}
