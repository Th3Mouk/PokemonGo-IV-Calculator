<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Entities;

class StaminaLevelCombinaison
{
    /**
     * @var Level
     */
    protected $level;

    /**
     * @var int
     */
    protected $stamina;

    /**
     * StaminaLevelCombinaison constructor.
     * @param Level $level
     * @param int   $stamina
     */
    public function __construct(Level $level, int $stamina)
    {
        $this->level = $level;
        $this->stamina = $stamina;
    }

    /**
     * Get level
     *
     * @return Level
     */
    public function getLevel(): Level
    {
        return $this->level;
    }

    /**
     * Get stamina
     *
     * @return int
     */
    public function getstamina(): int
    {
        return $this->stamina;
    }
}
