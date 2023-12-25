<?php
/*
 * @author Rajat Goyal
 */
namespace App\ChainCommandBundle\Contracts;

interface ChainInterface
{
    /**
     * Sets the name of the parent command.
     *
     * @param string $commandName
     * @return void
     */
    public function setParent(string $commandName): void;

    /**
     * Returns the name of the parent command.
     *
     * @return string|null
     */
    public function getParent(): ?string;
}