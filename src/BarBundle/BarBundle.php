<?php
/*
 * @author Rajat Goyal
 */
namespace App\BarBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use App\BarBundle\DependencyInjection\BarExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class BarBundle extends Bundle
{
	/**
     * @return ExtensionInterface|null
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new BarExtension();
    }
}
