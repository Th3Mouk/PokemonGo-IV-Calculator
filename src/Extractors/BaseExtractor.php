<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Extractors;

class BaseExtractor
{
    public function loadJson(string $path)
    {
        return json_decode(
            file_get_contents($path)
        );
    }
}
