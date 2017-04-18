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
     * @var int
     */
    protected $number;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $family;

    /**
     * @var string[]
     */
    protected $types;

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
     * @param int      $number
     * @param string   $name
     * @param int      $baseAttack
     * @param int      $baseDefense
     * @param int      $baseStamina
     * @param string[] $types
     * @param string   $familyId
     */
    public function __construct(
        int $number,
        string $name,
        string $familyId,
        int $baseAttack,
        int $baseDefense,
        int $baseStamina,
        array $types
    ) {
        $this->number = $number;
        $this->name = $name;
        $this->family = $familyId;
        $this->baseAttack = $baseAttack;
        $this->baseDefense = $baseDefense;
        $this->baseStamina = $baseStamina;
        $this->types = $types;
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
     * Return the min attack of a Pokemon
     * @return int
     */
    public function getMinAttack(): ?int
    {
        return $this->getIvCombinaisons()->min(
            function (IvCombinaison $combinaison) {
                return $combinaison->getAttack();
            });
    }

    /**
     * Return the max attack of a Pokemon
     * @return int
     */
    public function getMaxAttack(): ?int
    {
        return $this->getIvCombinaisons()->max(
            function (IvCombinaison $combinaison) {
                return $combinaison->getAttack();
            });
    }

    /**
     * Return the min defense of a Pokemon
     * @return int
     */
    public function getMinDefense(): ?int
    {
        return $this->getIvCombinaisons()->min(
            function (IvCombinaison $combinaison) {
                return $combinaison->getDefense();
            });
    }

    /**
     * Return the max defense of a Pokemon
     * @return int
     */
    public function getMaxDefense(): ?int
    {
        return $this->getIvCombinaisons()->max(
            function (IvCombinaison $combinaison) {
                return $combinaison->getDefense();
            });
    }

    /**
     * Return the min stamina of a Pokemon
     * @return int
     */
    public function getMinStamina(): ?int
    {
        return $this->getIvCombinaisons()->min(
            function (IvCombinaison $combinaison) {
                return $combinaison->getStamina();
            });
    }

    /**
     * Return the max stamina of a Pokemon
     * @return int
     */
    public function getMaxStamina(): ?int
    {
        return $this->getIvCombinaisons()->max(
            function (IvCombinaison $combinaison) {
                return $combinaison->getStamina();
            });
    }

    /**
     * Return the min level of a Pokemon
     * @return float
     */
    public function getMinLevel(): ?float
    {
        return $this->getIvCombinaisons()
            ->map(function (IvCombinaison $combinaison) {
                return $combinaison->getLevel()->getLevel();
            })
            ->sortBy(function ($value) {
                return $value;
            })
            ->first();
    }

    /**
     * Return the max level of a Pokemon
     * @return float
     */
    public function getMaxLevel(): ?float
    {
        return $this->getIvCombinaisons()
            ->map(function (IvCombinaison $combinaison) {
                return $combinaison->getLevel()->getLevel();
            })
            ->sortBy(function ($value) {
                return $value;
            })
            ->last();
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
     * Get number
     *
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
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
     * Get family
     *
     * @return string
     */
    public function getFamily(): string
    {
        return $this->family;
    }

    /**
     * Get types
     *
     * @return \string[]
     */
    public function getTypes(): array
    {
        return $this->types;
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
