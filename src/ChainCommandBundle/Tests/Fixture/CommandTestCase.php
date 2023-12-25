<?php
namespace App\ChainCommandBundle\Tests\Fixture;

use App\ChainCommandBundle\Console\Event\Listener;
use App\ChainCommandBundle\Service\ChainCommandRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Psr\Log\LoggerInterface;

class CommandTestCase extends KernelTestCase
{
    /**
     * Name of the event
     *
     * @var string
     */
    const EVENT_NAME = 'kernel.listener.console';

    /**
     * Symfony application reference
     *
     * @var Application
     */
    protected $application = null;

    /**
     * Dispatcher
     *
     * @var EventDispatcher
     */
    protected $dispatcher = null;

    /**
     * Chain listener
     *
     * @var Listener
     */
    protected $listener = null;

    /**
     * Set up for the tests
     *
     * @return void
     */
    public function setUp()
    {
        $this->bootApplication();
    }

    /**
     * Reset the configuration for each test
     *
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->application = null;
        $this->dispatcher  = null;
        $this->listener    = null;
    }

    /**
     * Initialize the application
     *
     * @return void
     */
    protected function bootApplication()
    {
        $this->bootKernel();

        $this->application = new Application(static::$kernel);
        $this->dispatcher  = new EventDispatcher;
        // Get the services required for testing
        $registry = new ChainCommandRegistry();
        $this->listener    = new Listener($registry);

        $this->dispatcher->addListener(static::EVENT_NAME, [
            $this->listener,
            'onConsoleCommand',
        ]);

        $this->dispatcher->addListener(static::EVENT_NAME, [
            $this->listener,
            'onConsoleTerminate',
        ]);

        $this->application->setDispatcher($this->dispatcher);
    }

    /**
     * Add a new command to be tested and return its tester environment
     *
     * @param Command $command
     *
     * @return CommandTester
     */
    protected function addCommand(Command $command)
    {
        $this->application->add($command);

        // Manually set the logger (replace 'logger' with the actual service name)
        $logger = self::$kernel->getContainer()->get('logger');
        $command->setLogger($logger);

        return new CommandTester($command);
    }

    /**
     * Fire the event to catch the console event
     *
     * @param Command         $command
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function fireEvent(Command $command, InputInterface $input, OutputInterface $output)
    {
        $event = new ConsoleCommandEvent($command, $input, $output);
        $this->dispatcher->dispatch($event);
    }
}

