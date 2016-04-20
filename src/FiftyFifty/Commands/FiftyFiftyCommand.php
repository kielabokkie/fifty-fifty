<?php

namespace FiftyFifty\Commands;

use Faker\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FiftyFiftyCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('gamble')
            ->setDescription('Gamble')
            ->addArgument(
                'iterations',
                null,
                'How many times should the message be printed?',
                100000
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $iterations = $input->getArgument('iterations');

        $faker = Factory::create();
        $results = [];

        for ($x=0; $x < $iterations; $x++) {
            for ($i=0; $i <= 50; $i++) {
                // True or false
                $boolean = $faker->boolean(50);

                if (isset($results[$i]) === false) {
                    $results[$i] = 0;
                }

                if ($boolean === true) {
                    $results[$i] = $results[$i]+1;
                    break;
                }
            }
        }

        $output->write(print_r($results));
    }
}
