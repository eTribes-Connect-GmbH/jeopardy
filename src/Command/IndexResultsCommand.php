<?php

namespace App\Command;

use App\Result\ResultIndexServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class IndexResultsCommand extends Command
{
    protected static $defaultName = 'app:index-results';

    /**
     * @var ResultIndexServiceInterface
     */
    protected $resultIndexService;

    public function __construct(string $name = null, ResultIndexServiceInterface $resultIndexService)
    {
        $this->resultIndexService = $resultIndexService;
        parent::__construct($name);
    }


    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command');;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->resultIndexService->buildIndices();

        $io->success('re-indexed view tables');

        return 0;
    }
}
