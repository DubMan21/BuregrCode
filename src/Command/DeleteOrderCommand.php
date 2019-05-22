<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Repository\TheOrderRepository;

class DeleteOrderCommand extends Command
{
    protected static $defaultName = 'app:order:delete';

    /**
     * @var TheOrderRepository
     */
    protected $repository;

    public function __construct(TheOrderRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Removes uncommitted orders created more than 10 hours ago in the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->repository->deleteUselessOrder();
        
    }
}
