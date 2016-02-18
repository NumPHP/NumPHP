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
 * Class Cholesky
 *
 * @package   NumPHPExamples
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */
class Cholesky extends Command
{
    protected function configure()
    {
        $this->setName('cholesky')
            ->setDescription('Factors a symmetric positive definite matrix in to a lower triangular matrix');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $matrixA = new NumArray(
            [
                [  49,  -525,     7,   -315],
                [-525,  6921, -3279,   3483],
                [   7, -3279,  8178,   -328],
                [-315,  3483,  -328, 624556]
            ]
        );
        $output->writeln('<comment>Matrix A:</comment>');
        $output->writeln($matrixA->__toString());

        $output->writeln('<info>Cholesky:</info>');
        $time = microtime(true);
        $matrixL = LinAlg::cholesky($matrixA);
        $timeDiff = microtime(true) - $time;

        $output->writeln($matrixL->__toString());

        $output->writeln('<info>Time for calculation: '.$timeDiff.' sec</info>');
    }
}
