<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Entities;

use Th3Mouk\PokemonGoIVCalculator\Exceptions\AbbreviationNotExists;

class IvCombinaison
{
    /**
     * @var Level
     */
    protected $level;

    /**
     * @var int
     */
    protected $attack;

    /**
     * @var int
     */
    protected $defense;

    /**
     * @var int
     */
    protected $stamina;

    /**
     * IvCombinaison constructor.
     * @param Level $level
     * @param int   $attack
     * @param int   $defense
     * @param int   $stamina
     */
    public function __construct(
        Level $level,
        int $attack,
        int $defense,
        int $stamina
    ) {
        $this->level = $level;
        $this->attack = $attack;
        $this->defense = $defense;
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
     * Get attack
     *
     * @return int
     */
    public function getAttack(): int
    {
        return $this->attack;
    }

    /**
     * Get defense
     *
     * @return int
     */
    public function getDefense(): int
    {
        return $this->defense;
    }

    /**
     * Get stamina
     *
     * @return int
     */
    public function getStamina(): int
    {
        return $this->stamina;
    }

    /**
     * @param $abbr
     * @throws AbbreviationNotExists
     * @return int
     */
    public function getAbbreviated($abbr): int
    {
        switch ($abbr) {
            case 'atk':
                return $this->getAttack();
            case 'def':
                return $this->getDefense();
            case 'hp':
                return $this->getStamina();
        }
    }

    /**
     * Return the minimal iv stat
     * @return int
     */
    public function getMaximalIv(): int
    {
        return max($this->attack, $this->defense, $this->stamina);
    }

    /**
     * Return the maximal iv stat
     * @return int
     */
    public function getMinimalIv(): int
    {
        return min($this->attack, $this->defense, $this->stamina);
    }

    /**
     * Return the total of iv stats
     * @return int
     */
    public function getTotal(): int
    {
        return
            $this->getAttack() +
            $this->getDefense() +
            $this->getStamina();
    }

    /**
     * Get the average perfection of the combinaison
     * @return float
     */
    public function getPerfection(): float
    {
        return round($this->getTotal() / 45, 3) * 100;
    }
}
