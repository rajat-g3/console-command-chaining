<?php
/*
 * @author Rajat Goyal
 */
namespace App\FooBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use App\FooBundle\DependencyInjection\FooExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class FooBundle extends Bundle
{
	/**
     * @return ExtensionInterface|null
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new FooExtension();
    }
}
