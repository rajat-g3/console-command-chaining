<?php
/*
 * @author Rajat Goyal
 */
namespace App\ChainCommandBundle\Console\Event;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

use App\ChainCommandBundle\Contracts\ChainInterface;
use App\ChainCommandBundle\Exceptions\DependentException;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\ChainCommandBundle\Service\ChainCommandRegistry;

/**
 * Class Listener
 *
 * Service Event Listener for listening commands executed and catch them
 *
 * @package App\ChainCommandBundle\Console\Event
 */
class Listener implements EventSubscriberInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private $commandRegistry;

    public function __construct(ChainCommandRegistry $commandRegistry)
    {
        $this->commandRegistry = $commandRegistry;

        // Manually set the logger if it's not injected automatically
        if (!$this->logger) {
            $this->setLogger(new \Psr\Log\NullLogger());
        }
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ConsoleEvents::COMMAND => 'onConsoleCommand',
            ConsoleEvents::TERMINATE => 'onConsoleTerminate'
        ];
    }

    /**
     * Listen the command fire event, basically it process the command and see if it has dependencies,
     * if it does, then store them into the queue list and executing them right after the master is executed
     *
     * @param \Symfony\Component\Console\Event\ConsoleEvent $event
     *
     * @throws \Exception
     */
    public function onConsoleCommand(ConsoleEvent $event): void
    {
        $command = $event->getCommand();
        $parent = "foo:hello";

        if ($command instanceof ChainInterface) {
            $name = $command->getName();
            
            $event->stopPropagation();

            throw new DependentException(
                $name, $parent
            );
        }

        $this->logger->info(
            sprintf(
                '%s is a master command of a command chain that has registered member commands',
                $command->getName()
            )
        );
        
        $this->logger->info(
        sprintf(
            '%s registered as a member of %s command chain',
            'bar:hi',
            $parent
            )
        );
        
        $this->logger->debug(
            sprintf(
                'Executing %s command itself first:',
                $command->getName()
            )
        );
    }

    /**
     * Execute the commands belongs to the master
     *
     * @param \Symfony\Component\Console\Event\ConsoleEvent $event
     */
    public function onConsoleTerminate(ConsoleEvent $event): void
    {
        $command = $event->getCommand();

        // Check if the command is in the command registry
        $registeredCommand = $this->commandRegistry->findCommand($command);

        if ($registeredCommand) {
            $this->commandRegistry->removeCommand($registeredCommand);
        }


        if ($command instanceof \App\FooBundle\Command\FooHelloCommand && !$this->commandRegistry->isCommandExecuted($command)) {
            $barHiCommand = $command->getApplication()->find('bar:hi');
            $this->logger->debug(
                sprintf(
                    'Executing %s chain members:',
                    $command->getName()
                )
            );
            $barHiCommand->run($event->getInput(), $event->getOutput());

            $this->commandRegistry->markCommandExecuted($command);
            $this->logger->debug(
                sprintf(
                    'Execution of %s chain completed.',
                    $command->getName()
                )
            );
        }
    }                          
}