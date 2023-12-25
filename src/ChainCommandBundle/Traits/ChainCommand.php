<?php
/*
 * @author Rajat Goyal
 */
namespace App\ChainCommandBundle\Traits;

/**
 * Class ChainCommand
 *
 * Extends the functionality of the commands to be able to register it to any master command
 *
 * @package App\ChainCommandBundle\Traits
 */
trait ChainCommand
{
    protected $parent = null;

    public function setParent(string $commandName): void
    {
        $this->parent = $commandName;
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }
}