<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Calculator;

use Th3Mouk\PokemonGoIVCalculator\Entities\Level;
use Th3Mouk\PokemonGoIVCalculator\Extractors\LevelExtractor;

class Helpers
{
    /**
     * Method to calculate how many dusts are necessary to max a pokemon
     * @param  float $pokemon the level of the pokemon
     * @param  float $trainer the level of the the trainer
     * @return int   dusts to max the pokemon
     */
    public static function dustsToMax(float $pokemon, float $trainer)
    {
        $trainer += 1.5;
        $loop = $pokemon;
        $dusts = 0;

        if ($pokemon >= $trainer) {
            return 0;
        }

        if ($trainer > 40) {
            $trainer = 40;
        }

        $levels = (new LevelExtractor())
            ->getIntervalLevelFiltered($pokemon, $trainer);

        $levels
            ->each(function ($level) use (&$dusts, &$loop, $trainer) {
                $loop += 0.5;
                $dusts += $level->dust * 2;
            });

        if ($pokemon*2 % 2 === 1) {
            $dusts -= $levels->first()->dust;
        }

        $dusts -= $levels->last()->dust;

        return $dusts;
    }

    /**
     * Method to calculate how many candies are necessary to max a pokemon
     * @param  float $pokemon the level of the pokemon
     * @param  float $trainer the level of the the trainer
     * @return int   dusts to max the pokemon
     */
    public static function candiesToMax(float $pokemon, float $trainer)
    {
        $trainer += 1.5;
        $loop = $pokemon;
        $candies = 0;

        if ($pokemon >= $trainer) {
            return 0;
        }

        if ($trainer > 40) {
            $trainer = 40;
        }

        $levels = (new LevelExtractor())
            ->getIntervalLevelFiltered($pokemon, $trainer);

        $levels
            ->each(function ($level) use (&$candies, &$loop, $trainer) {
                $loop += 0.5;
                $candies += $level->candy * 2;
            });

        if ($pokemon*2 % 2 === 1) {
            $candies -= $levels->first()->candy;
        }

        $candies -= $levels->last()->candy;

        return $candies;
    }

    /**
     * Method to calculate the CP with stats
     * @param  int  $attack
     * @param  int  $defense
     * @param  int  $stamina
     * @param  int  $level
     * @param  bool $upgraded
     * @return int
     */
    public static function calculateCP(int $attack, int $defense, int $stamina, int $level, bool $upgraded = false)
    {
        $attackFactor = $attack;
        $defenseFactor = pow($defense, 0.5);
        $staminaFactor = pow($stamina, 0.5);

        $datas = (new LevelExtractor())->getExactLevel($level);
        $level = new Level(
            $datas->level, $datas->dust, $datas->cpScalar, $upgraded
        );

        $scalarFactor = pow($level->getCpScalar(), 2);

        return floor($attackFactor * $defenseFactor * $staminaFactor * $scalarFactor / 10);
    }
}
