<?php
namespace App\ChainCommandBundle\Exceptions;

use Exception;
use Symfony\Component\Console\Exception\ExceptionInterface;

class DependentException extends Exception implements ExceptionInterface
{
	/**
     * NotMasterCommandException constructor.
     *
     * @param string $commandName Command name
     */
    public function __construct(string $commandName, string $parentName)
    {
        $message = sprintf(
            'Error: %s command is a member of %s command chain and cannot be executed on its own.',
            $commandName,
            $parentName
        );

        parent::__construct($message);
    }
}