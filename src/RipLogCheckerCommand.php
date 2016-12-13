<?php

namespace RipLogChecker;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RipLogCheckerCommand extends Command
{
    protected function configure() {
        $this->setName('check');
        $this->setHelp('Checks given log file');
        $this->addArgument('log', InputArgument::REQUIRED, 'The path to the log file to process');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $log = $input->getArgument('log');

        $ripLogChecker = new RipLogChecker(new LogIdentifier());

        try {
            $result = $ripLogChecker->parse(file_get_contents($log));


        } catch (Exception $exception) {
            $output->writeln($exception->getMessage());
            return 0;
        }

        $output->writeln('Score: ' . $result->getScore());

        if (!$result->hasErrors()) {
            $output->writeln('There were no errors reported.');
            return 0;
        }

        $output->writeln('There are ' . $result->getNumErrors() . ' errors reported.');

        foreach ($result->getErrorMessages() as $errorMessage) {
            $output->writeln($errorMessage);
        }

        return 1;
    }
}