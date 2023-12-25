<?php
/*
 * @author Rajat Goyal
 */
namespace App\FooBundle\Tests\Command;

use App\ChainCommandBundle\Tests\Fixture\CommandTestCase;
use App\FooBundle\Command\FooHelloCommand;

class FooHelloCommandTest extends CommandTestCase
{
    /**
     * Test the execution of the command
     *
     * @return void
     */
    public function testExecute()
    {
        $command       = new FooHelloCommand;
        $commandTester = $this->addCommand($command);

        $commandTester->execute([
            'command' => $command,
        ]);

        $this->fireEvent($command, $commandTester->getInput(), $commandTester->getOutput());

        $output = $commandTester->getDisplay();

        $this->assertContains('Hello from Foo!', $output);
    }
}
