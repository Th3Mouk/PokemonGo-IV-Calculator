<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Calculator;

use Illuminate\Support\Collection;
use Th3Mouk\PokemonGoIVCalculator\Entities\IvCombinaison;
use Th3Mouk\PokemonGoIVCalculator\Entities\Level;
use Th3Mouk\PokemonGoIVCalculator\Entities\Pokemon;
use Th3Mouk\PokemonGoIVCalculator\Entities\StaminaLevelCombinaison;
use Th3Mouk\PokemonGoIVCalculator\Extractors\LevelExtractor;
use Th3Mouk\PokemonGoIVCalculator\Extractors\Pokedex;

class Calculator
{
    private const AVAILABLE_OPTIONS = ['atk', 'def', 'hp'];

    private $attack_range;
    private $defense_range;
    private $stamina_range;

    /**
     * @var Collection
     */
    private $potentialLevels;

    /**
     * @var Collection
     */
    private $potentialStamina;

    /**
     * @var Collection
     */
    private $potentialCombinaisons;

    /**
     * Calculator constructor.
     */
    public function __construct()
    {
        $this->attack_range = range(0, 15);
        $this->defense_range = range(0, 15);
        $this->stamina_range = range(0, 15);

        $this->potentialLevels = new Collection();
        $this->potentialStamina = new Collection();
        $this->potentialCombinaisons = new Collection();
    }

    /**
     * Process all operations to retrieve differents IV combinaisons
     * @param  string  $pokemonName
     * @param  int     $cp
     * @param  int     $hp
     * @param  int     $dusts
     * @param  int     $global
     * @param  int     $maxStat
     * @param  array   $bestStats
     * @param  bool    $upgraded
     * @return Pokemon
     */
    public function calculate(
        string $pokemonName,
        int $cp,
        int $hp,
        int $dusts,
        int $global,
        int $maxStat,
        array $bestStats,
        bool $upgraded = false
    ): Pokemon {
        $pokemon = (new Pokedex())->get($pokemonName);

        $pokemon->setCp($cp);
        $pokemon->setHp($hp);

        $bestStats = $this->cleanBestStats($bestStats);

        $this->setRanges($bestStats, $maxStat);

        $this->potentialLevels = (new LevelExtractor())->getDustFiltered($dusts);

        $this
            ->findPotentialStamina($pokemon, $hp, $upgraded)
            ->findPotentialCombinaisons($pokemon, $cp)
            ->cleanImpossibleCombinaisons($bestStats, $global);

        $pokemon->setIvCombinaisons($this->potentialCombinaisons);

        return $pokemon;
    }

    /**
     * Retrieve the possible level and stamina IV to match HP
     * @param  Pokemon $pokemon
     * @param  int     $hp
     * @param  bool    $upgraded
     * @return $this
     */
    private function findPotentialStamina(
        Pokemon $pokemon,
        int $hp,
        bool $upgraded
    ) {
        foreach ($this->potentialLevels as $data) {
            $level = new Level(
                $data->level, $data->dust, $data->cpScalar, $upgraded
            );

            foreach ($this->stamina_range as $staminaIV) {
                if ($this->testHP($pokemon, $level, $hp, $staminaIV)) {
                    $combinaison = new StaminaLevelCombinaison(
                        $level,
                        $staminaIV
                    );
                    $this->potentialStamina->push($combinaison);
                }
            }
        }

        return $this;
    }

    /**
     * Test remaining combinaisons which match CP
     * @param  Pokemon $pokemon
     * @param  int     $cp
     * @return $this
     */
    private function findPotentialCombinaisons(Pokemon $pokemon, int $cp)
    {
        foreach ($this->potentialStamina as $staminaCombinaison) {
            foreach ($this->attack_range as $attackIV) {
                foreach ($this->defense_range as $defenseIV) {
                    if ($this->testCP(
                        $pokemon,
                        $staminaCombinaison->getLevel(),
                        $cp,
                        $attackIV,
                        $defenseIV,
                        $staminaCombinaison->getStamina())
                    ) {
                        $combinaison = new IvCombinaison(
                            $staminaCombinaison->getLevel(),
                            $attackIV,
                            $defenseIV,
                            $staminaCombinaison->getStamina()
                        );

                        $this->potentialCombinaisons->push($combinaison);
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Remove impossible combinaisons with coach indications
     * @param  array $bestStats
     * @param  int   $global
     * @return $this
     */
    private function cleanImpossibleCombinaisons(array $bestStats, int $global)
    {
        $this->potentialCombinaisons = $this->potentialCombinaisons
            // Eliminate impossible combinaison for global combinaison
            ->filter(function ($combinaison) use ($global) {
                if ($combinaison->getTotal() <= $this->getMaxGlobalEvaluation($global) &&
                    $combinaison->getTotal() > $this->getMaxGlobalEvaluation($global-1)) {
                    return true;
                }
                return false;
            })
            // Eliminate impossible combinaisons with best stats
            ->filter(function ($combinaison) use ($bestStats) {
                $nonBestStats = array_diff(self::AVAILABLE_OPTIONS, $bestStats);
                foreach ($nonBestStats as $nonBestStat) {
                    if ($combinaison->getAbbreviated($nonBestStat) < $combinaison->getMaximalIv()) {
                        return true;
                    }
                    return false;
                }
            });

        return $this;
    }

    /**
     * Remove unavailable options give by user
     * @param $bestStats
     * @return array
     */
    private function cleanBestStats($bestStats): array
    {
        return array_intersect(self::AVAILABLE_OPTIONS, $bestStats);
    }

    /**
     * Remove impossible values for differents IV with coach indications
     * @param array $bestStats
     * @param int   $maxStat
     */
    private function setRanges(array $bestStats, int $maxStat)
    {
        $this->setRange($bestStats, $maxStat, 'atk', $this->attack_range);
        $this->setRange($bestStats, $maxStat, 'def', $this->defense_range);
        $this->setRange($bestStats, $maxStat, 'hp', $this->stamina_range);
    }

    private function setRange($bestStats, $maxStat, $option, &$property)
    {
        if (in_array($option, $bestStats)) {
            $property = $this->getMaxRange($maxStat);
        } else {
            $property = $this->getLowerRange($maxStat);
        }
    }

    /**
     * Calculate if a combinaison of value match the given CP
     * @param  Pokemon $pokemon
     * @param  Level   $level
     * @param  int     $cp
     * @param  int     $attackIV
     * @param  int     $defenseIV
     * @param  int     $staminaIV
     * @return bool
     */
    private function testCP(
        Pokemon $pokemon,
        Level $level,
        int $cp,
        int $attackIV,
        int $defenseIV,
        int $staminaIV
    ) {
        $attackFactor = $pokemon->getBaseAttack() + $attackIV;
        $defenseFactor = pow($pokemon->getBaseDefense() + $defenseIV, 0.5);
        $staminaFactor = pow($pokemon->getBaseStamina() + $staminaIV, 0.5);
        $scalarFactor = pow($level->getCpScalar(), 2);

        return $cp == floor($attackFactor * $defenseFactor * $staminaFactor * $scalarFactor / 10);
    }

    /**
     * Calculate if a combinaison of value match the given HP
     * @param  Pokemon $pokemon
     * @param  Level   $level
     * @param  int     $hp
     * @param  int     $staminaIV
     * @return bool
     */
    private function testHP(
        Pokemon $pokemon,
        Level $level,
        int $hp,
        int $staminaIV
    ) {
        return $hp == (int) floor(($pokemon->getBaseStamina() + $staminaIV) * $level->getCpScalar());
    }

    /**
     * Return the range of stats given by the coach
     * @param  int   $maxStat
     * @return array
     */
    private function getMaxRange(int $maxStat)
    {
        switch ($maxStat) {
            case 1:
                return range(0, 7);
            case 2:
                return range(8, 12);
            case 3:
                return range(13, 14);
            case 4:
                return [15];
        };
        return range(0, 15);
    }

    /**
     * Return the range of stats non cited by the coach
     * @param  int   $maxStat
     * @return array
     */
    private function getLowerRange(int $maxStat)
    {
        switch ($maxStat) {
            case 1:
                return range(0, 6);
            case 2:
                return range(0, 11);
            case 3:
                return range(0, 13);
            case 4:
                return range(0, 14);
        };
        return range(0, 15);
    }

    /**
     * Get the threshold of the global evaluation given by the coach
     * @param $global
     * @return int
     */
    private function getMaxGlobalEvaluation($global)
    {
        switch ($global) {
            case 0:
            case 1:
                // 0-22
                return 22;
            case 2:
                // 23-29
                return 29;
            case 3:
                // 30-36
                return 36;
        }
        // 37-45
        return 45;
    }

    /**
     * Get attack_range
     *
     * @return array
     */
    public function getAttackRange(): array
    {
        return $this->attack_range;
    }

    /**
     * Get defense_range
     *
     * @return array
     */
    public function getDefenseRange(): array
    {
        return $this->defense_range;
    }

    /**
     * Get stamina_range
     *
     * @return array
     */
    public function getStaminaRange(): array
    {
        return $this->stamina_range;
    }

    /**
     * Get potentialLevels
     *
     * @return Collection
     */
    public function getPotentialLevels(): Collection
    {
        return $this->potentialLevels;
    }

    /**
     * Get potentialStamina
     *
     * @return Collection
     */
    public function getPotentialStamina(): Collection
    {
        return $this->potentialStamina;
    }

    /**
     * Get potentialCombinaisons
     *
     * @return Collection
     */
    public function getPotentialCombinaisons(): Collection
    {
        return $this->potentialCombinaisons;
    }
}
