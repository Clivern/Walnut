<?php

declare(strict_types=1);

/*
 * This file is part of the Clivern/Walnut project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Command;

use Clivern\Chunk\Core\Listener;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Stream Command.
 */
class StreamCommand extends Command
{
    protected static $defaultName        = 'stream';
    protected static $defaultDescription = 'Listens to Incoming Messages';
    private $listener;

    /**
     * Class constructor.
     */
    public function __construct(Listener $listener)
    {
        parent::__construct();
        $this->listener = $listener;
    }

    /**
     * Configure command.
     */
    protected function configure()
    {
        return $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    /**
     * Execute command.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io   = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $this->listener->connect();
        $this->listener->listen();
        $this->listener->disconnect();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
