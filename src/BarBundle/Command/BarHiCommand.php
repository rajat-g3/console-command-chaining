<?php
/*
 * @author Rajat Goyal
 */
namespace App\BarBundle\Command;

use App\ChainCommandBundle\Traits\ChainCommand;
use App\ChainCommandBundle\Contracts\ChainInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BarHiCommand extends Command implements ChainInterface, LoggerAwareInterface
{
    use ChainCommand,LoggerAwareTrait;
    /**
     * @var string
     */
    protected static $defaultName = 'bar:hi';

    protected static $defaultDescription = 'Outputs greetings from Bar.';

    /**
     * Execute command method
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output):int
    {
        // Manually set the logger if it's not injected automatically
        if (!$this->logger) {
            $this->setLogger(new \Psr\Log\NullLogger());
        }
        
        $output->writeln('Hi from Bar!');
        $this->logger->info('Hi from Bar!');

        return Command::SUCCESS;
    }

}
