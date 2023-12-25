<?php
/*
 * @author Rajat Goyal
 */
namespace App\BarBundle\Tests\Command;

use App\ChainCommandBundle\Tests\Fixture\CommandTestCase;
use App\BarBundle\Command\BarHiCommand;
use App\ChainCommandBundle\Service\ChainCommandRegistry;
use App\ChainCommandBundle\Console\Event\Listener;

class BarHiCommandTest extends CommandTestCase
{
    /**
     * Test the execution of the command
     *
     */
    public function testExecute()
    {
        // Bootstrap the Symfony Kernel
        self::bootKernel();

        // Get the services required for testing
        $registry = new ChainCommandRegistry();
        $listener = new Listener($registry);

        $command       = new BarHiCommand;
        $commandTester = $this->addCommand($command);

        $commandTester->execute([
            'command' => $command,
        ]);

        $this->fireEvent($command, $commandTester->getInput(), $commandTester->getOutput());

        $this->assertContains('Hi from Bar!', $commandTester->getDisplay());
    }
}
