<?php
/*
 * @author Rajat Goyal
 */
namespace App\ChainCommandBundle\Service;

use Symfony\Component\Console\Command\Command;

class ChainCommandRegistry
{
    private $executedCommands = [];

    private $commands = [];

    public function addCommand(Command $command): void
    {
        $this->commands[] = $command;
    }

    public function findCommand(Command $command): ?Command
    {
        foreach ($this->commands as $key => $registeredCommand) {
            if ($this->areCommandsEqual($registeredCommand, $command)) {
                return $registeredCommand;
            }
        }

        return null;
    }

    public function removeCommand(Command $command): void
    {
        foreach ($this->commands as $key => $registeredCommand) {
            if ($this->areCommandsEqual($registeredCommand, $command)) {
                unset($this->commands[$key]);
                break;
            }
        }
    }

    private function areCommandsEqual(Command $command1, Command $command2): bool
    {
        // For simplicity, let's assume that commands are equal if their names match.
        return $command1->getName() === $command2->getName();
    }

    public function markCommandExecuted(Command $command): void
    {
        $this->executedCommands[get_class($command)] = true;
    }

    public function isCommandExecuted(Command $command): bool
    {
        return isset($this->executedCommands[get_class($command)]);
    }
}