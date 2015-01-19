<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPExamples;

use NumPHP\Core\NumArray;
use NumPHP\LinAlg\LinAlg;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Inverse
 *
 * @package   NumPHPExamples
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */
class Inverse extends Command
{
    protected function configure()
    {
        $this->setName('inverse')
            ->setDescription('Calculates the inverse of a not singular matrix');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $matrix = new NumArray(
            [
                [-3,   4, 7/6],
                [ 2, 0.1,   0],
                [23,  -5,   8]
            ]
        );
        $output->writeln('<comment>Matrix:</comment>');
        $output->writeln($matrix->__toString());

        $output->writeln('<info>Inverse:</info>');
        $time = microtime(true);
        $inv = LinAlg::inv($matrix);
        $timeDiff = microtime(true) -$time;

        $output->writeln($inv->__toString());

        $output->writeln('<info>Time for calculation: '.$timeDiff.' sec</info>');
    }
}
