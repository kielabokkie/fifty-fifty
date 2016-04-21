<?php

namespace FiftyFifty\Commands;

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
                'max_spend',
                null,
                'How much are you prepared to spend',
                1
            )
            ->addArgument(
                'starting_amount',
                null,
                'What is the minimum you can gamble?',
                0.00000001
            )
            ->addArgument(
                'iterations',
                null,
                'How many times do you want to play?',
                1
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $maxSpend = (float)$input->getArgument('max_spend');
        $startingAmount = (float)$input->getArgument('starting_amount');
        $iterations = (int)$input->getArgument('iterations');
        
        $wins = 0;
        $losses = 0;
        
        for ($i = 0; $i < $iterations; $i++) {
            if ($this->gamble($maxSpend, $startingAmount, ($iterations === 1) ? $output : null)) {
                $wins++;
            } else {
                $losses++;
            }
        }

        $output->writeln(sprintf("wins: %d, losses: %d", $wins, $losses));
    }

    public function gamble($maxSpend, $startingAmount, $output = null)
    {
        $remainingAmount = $maxSpend;
        $currentBet = $startingAmount;
        $numberOfBets = 0;

        while (true) {
            if ((mt_rand(0, 1) === 1)) {
                $remainingAmount -= ($currentBet + ($currentBet * 0.001));
            } else {
                $remainingAmount += ($currentBet - ($currentBet * 0.001));
            }
            if ($output) {
                $output->writeln(sprintf("#%d : %s : %s", $numberOfBets, $currentBet, $remainingAmount));
            }
            if ($remainingAmount > ($maxSpend * 2)) {
                if ($output) {
                    $output->writeln('win');
                }
                return true;
                break;
            } elseif ($remainingAmount < 0) {
                if ($output) {
                    $output->writeln('lose');
                }
                return false;
                break;
            }
            $currentBet *= 2;
            $numberOfBets++;
        }
    }
}
