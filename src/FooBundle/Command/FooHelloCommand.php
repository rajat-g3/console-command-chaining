<?php
/*
 * @author Rajat Goyal
 */
namespace App\FooBundle\Command;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\NullLogger;

class FooHelloCommand extends Command implements LoggerAwareInterface
{
    use LoggerAwareTrait;
    /**
     * @var string
     */
    protected static $defaultName = 'foo:hello';

    protected static $defaultDescription = 'Outputs greetings from Foo.';

    /**
     * Execute command method
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Manually set the logger if it's not injected automatically
    if (!$this->logger) {
        $this->setLogger(new NullLogger());
    }

        $output->writeln('Hello from Foo!');
        $this->logger->info('Hello from Foo!');

        return Command::SUCCESS;
    }

}
