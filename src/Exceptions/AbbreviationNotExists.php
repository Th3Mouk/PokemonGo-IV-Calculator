<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Exceptions;

class AbbreviationNotExists extends \Exception
{
    public function __construct($abbreviation)
    {
        parent::__construct('Abbreviation '.$abbreviation.' doesn\'t exists');
    }
}
