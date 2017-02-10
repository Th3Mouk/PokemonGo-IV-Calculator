Pokemon Go IV Calculator
========================

This PHP library is the most accurate to calculate Pokemons IV's.

[![Latest Stable Version](https://poser.pugx.org/th3mouk/pokemongo-iv-calc/v/stable)](https://packagist.org/packages/th3mouk/pokemongo-iv-calc) [![Latest Unstable Version](https://poser.pugx.org/th3mouk/pokemongo-iv-calc/v/unstable)](https://packagist.org/packages/th3mouk/pokemongo-iv-calc) [![Total Downloads](https://poser.pugx.org/th3mouk/pokemongo-iv-calc/downloads)](https://packagist.org/packages/th3mouk/pokemongo-iv-calc) [![License](https://poser.pugx.org/th3mouk/pokemongo-iv-calc/license)](https://packagist.org/packages/th3mouk/pokemongo-iv-calc)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8949771b-1e7a-437f-a239-1c5f8addb75d/mini.png)](https://insight.sensiolabs.com/projects/8949771b-1e7a-437f-a239-1c5f8addb75d) [![Build Status](https://travis-ci.org/Th3Mouk/PokemonGo-IV-Calculator.svg?branch=master)](https://travis-ci.org/Th3Mouk/PokemonGo-IV-Calculator) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Th3Mouk/PokemonGo-IV-Calculator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Th3Mouk/PokemonGo-IV-Calculator/?branch=master)

## Installation

`composer require th3mouk/pokemongo-iv-calc`

## Usage

### From command line

```sh
php bin/ivcalculator calculate bulbasaur 515 59 2500 4 3 def

php bin/ivcalculator calculate bulbasaur xxx xx 2500 4 3 def atk hp
```

### Use the class

```php
$pokemon = (new Calculator())->calculate(
    $input->getArgument('name'),
    (int) $input->getArgument('cp'),
    (int) $input->getArgument('hp'),
    (int) $input->getArgument('dusts'),
    (int) $input->getArgument('global'),
    (int) $input->getArgument('max-stats'),
    $input->getArgument('bests'),
    (bool) $input->getOption('upgraded')
);
```

To manipulate different IV combinaisons I use [Illuminate\Collection](https://github.com/tightenco/collect).

So `pokemon->getIvCombinaisons()` will return a Collection easily manipulable.

### Parameters:

- Name of the pokemon in english :uk:
- CP
- HP
- Dusts
- 1/2/3/4 [see steps here](https://pokemongo.gamepress.gg/pokemon-appraisal)
- 1/2/3/4 [see steps here](https://pokemongo.gamepress.gg/pokemon-appraisal)
- Finish the command with stats given by the coach (`atk` and/or `def` and/or `hp`)

Where :

`1` is the worst appreciation (<8 for an IV or <50% for global)

And

`4` is the best range (15 for an IV or >80% global IV)

## Contributing

Before commiting, please run `vendor/bin/php-cs-fixer fix .` command, and update the test suite.

To launch the test suite:

```sh
php vendor/bin/peridot tests
```

## Please

Feel free to improve this library.
