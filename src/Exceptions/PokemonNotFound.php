<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Exceptions;

class PokemonNotFound extends NotFound
{
    public function __construct($name)
    {
        parent::__construct(ucfirst($name).' doesn\'t exists');
    }
}
