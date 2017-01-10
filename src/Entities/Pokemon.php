<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Entities;

use Illuminate\Support\Collection;

class Pokemon
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $cp;

    /**
     * @var int
     */
    protected $hp;

    /**
     * @var int
     */
    protected $baseAttack;

    /**
     * @var int
     */
    protected $baseDefense;

    /**
     * @var int
     */
    protected $baseStamina;

    /**
     * @var Collection
     */
    protected $ivCombinaisons;

    /**
     * Pokemon constructor.
     * @param string $name
     * @param int $baseAttack
     * @param int $baseDefense
     * @param int $baseStamina
     */
    public function __construct(
        string $name,
        int $baseAttack,
        int $baseDefense,
        int $baseStamina
    ) {
        $this->name = $name;
        $this->baseAttack = $baseAttack;
        $this->baseDefense = $baseDefense;
        $this->baseStamina = $baseStamina;
    }

    /**
     * Return the minimum of perfection of a Pokemon
     * @return IvCombinaison|null
     */
    public function getMinimumCombinaison(): ?IvCombinaison
    {
        return $this->getIvCombinaisons()
            ->sortBy(
                function (IvCombinaison $combinaison) {
                    return $combinaison->getPerfection();
                })
            ->last();
    }

    /**
     * Return the maximum of perfection of a Pokemon
     * @return IvCombinaison|null
     */
    public function getMaximumCombinaison(): ?IvCombinaison
    {
        return $this->getIvCombinaisons()
            ->sortBy(
                function (IvCombinaison $combinaison) {
                    return $combinaison->getPerfection();
                })
            ->first();
    }

    /**
     * Return the average perfection of a Pokemon
     * @return float|null
     */
    public function getAveragePerfection(): ?float
    {
        return $this->getIvCombinaisons()->average(
            function (IvCombinaison $combinaison) {
                return $combinaison->getPerfection();
            });
    }

    /**
     * Get ivCombinaisons
     *
     * @return Collection
     */
    public function getIvCombinaisons(): Collection
    {
        return $this->ivCombinaisons;
    }

    /**
     * Set ivCombinaisons
     *
     * @param Collection $ivCombinaisons
     *
     * @return Pokemon
     */
    public function setIvCombinaisons(Collection $ivCombinaisons)
    {
        $this->ivCombinaisons = $ivCombinaisons;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get cp
     *
     * @return int|null
     */
    public function getCp(): ?int
    {
        return $this->cp;
    }

    /**
     * Set cp
     *
     * @param int $cp
     *
     * @return Pokemon
     */
    public function setCp(int $cp)
    {
        $this->cp = $cp;
        return $this;
    }

    /**
     * Get hp
     *
     * @return int|null
     */
    public function getHp(): ?int
    {
        return $this->hp;
    }

    /**
     * Set hp
     *
     * @param int $hp
     *
     * @return Pokemon
     */
    public function setHp(int $hp)
    {
        $this->hp = $hp;
        return $this;
    }

    /**
     * Get baseAttack
     *
     * @return int
     */
    public function getBaseAttack(): int
    {
        return $this->baseAttack;
    }

    /**
     * Get baseDefense
     *
     * @return int
     */
    public function getBaseDefense(): int
    {
        return $this->baseDefense;
    }

    /**
     * Get baseStamina
     *
     * @return int
     */
    public function getBaseStamina(): int
    {
        return $this->baseStamina;
    }
}
