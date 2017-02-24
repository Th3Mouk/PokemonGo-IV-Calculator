<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Entities;

class Level
{
    private const ADSCALAR_UNDER_10 = 0.009426125571;
    private const ADSCALAR_UNDER_20 = 0.008919021209;
    private const ADSCALAR_UNDER_30 = 0.008924887876;
    private const ADSCALAR_UNDER_40 = 0.00445945781;

    /**
     * @var int
     */
    protected $level;

    /**
     * @var int
     */
    protected $dust;

    /**
     * @var float
     */
    protected $cpScalar;

    /**
     * @var bool
     */
    protected $upgraded;

    /**
     * Level constructor.
     * @param int   $level
     * @param int   $dust
     * @param float $cpScalar
     * @param bool  $upgraded
     */
    public function __construct($level, $dust, $cpScalar, $upgraded = false)
    {
        $this->level = $level;
        $this->dust = $dust;
        $this->cpScalar = $cpScalar;
        $this->upgraded = $upgraded;
    }

    /**
     * Get level
     *
     * @return float
     */
    public function getLevel(): float
    {
        if ($this->upgraded) {
            return $this->level + 0.5;
        }
        return $this->level;
    }

    /**
     * Get dust
     *
     * @return int
     */
    public function getDust(): int
    {
        return $this->dust;
    }

    /**
     * Get CP Scalar by Pokemon level
     *
     * @return float
     */
    public function getCpScalar(): float
    {
        if ($this->isUpgraded()) {
            if ($this->level < 10) {
                return sqrt(pow($this->cpScalar, 2) + self::ADSCALAR_UNDER_10);
            } elseif ($this->level < 20) {
                return sqrt(pow($this->cpScalar, 2) + self::ADSCALAR_UNDER_20);
            } elseif ($this->level < 30) {
                return sqrt(pow($this->cpScalar, 2) + self::ADSCALAR_UNDER_30);
            }
            return sqrt(pow($this->cpScalar, 2) + self::ADSCALAR_UNDER_40);
        }
        return $this->cpScalar;
    }

    /**
     * Get upgraded
     *
     * @return bool
     */
    public function isUpgraded(): bool
    {
        return $this->upgraded;
    }
}
