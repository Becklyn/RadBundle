<?php declare(strict_types=1);

namespace Becklyn\RadBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class BecklynRadExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load (array $configs, ContainerBuilder $container) : void
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }
}