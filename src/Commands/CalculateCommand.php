<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\PokemonGoIVCalculator\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Th3Mouk\PokemonGoIVCalculator\Calculator\Calculator;
use Th3Mouk\PokemonGoIVCalculator\Entities\IvCombinaison;

class CalculateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('calculate')
            ->setDescription('Calculate IV combinaisons of a Pokemon');

        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Pokemon\'s name')
            ->addArgument('cp', InputArgument::REQUIRED)
            ->addArgument('hp', InputArgument::REQUIRED)
            ->addArgument(
                'dusts',
                InputArgument::REQUIRED,
                'Stardust needed for power up'
            )
            ->addArgument(
                'global',
                InputArgument::REQUIRED,
                '1/2/3/4 for globalement evalutation'
            )
            ->addArgument(
                'max-stats',
                InputArgument::REQUIRED,
                '1/2/3/4 for best stat evalutation'
            )
            ->addArgument(
                'bests',
                InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                'atk def hp separated with spaces'
            )
            ->addOption(
                'upgraded',
                'up',
                InputArgument::OPTIONAL,
                'Is the Pokemon was powered up?',
                false
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
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

        $output->writeln('====================================');
        $output->writeln(
            sprintf(
                "%s (%.1f%%)   %.1f%% / %.1f%%",
                ucfirst($pokemon->getName()),
                $pokemon->getAveragePerfection(),
                $pokemon->getMinimumCombinaison()->getPerfection(),
                $pokemon->getMaximumCombinaison()->getPerfection()
            )
        );
        $output->writeln("====================================");

        (new Table($output))
            ->setHeaders(['Level', 'Attack IV', 'Defense IV', 'Stamina IV', 'Perfection'])
            ->setRows($pokemon->getIvCombinaisons()->map(function (IvCombinaison $combinaison) {
                return [
                    $combinaison->getLevel()->getLevel(),
                    $combinaison->getAttack(),
                    $combinaison->getDefense(),
                    $combinaison->getStamina(),
                    sprintf('%.1f%%', $combinaison->getPerfection()),
                ];
            })->toArray())->render();
    }
}
