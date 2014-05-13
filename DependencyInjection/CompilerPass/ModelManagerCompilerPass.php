<?php

namespace HCLabs\ModelManagerBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ModelManagerCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $modelManagerList = $container->findTaggedServiceIds('hclabs.model_manager');

        foreach($modelManagerList as $id => $attributes)
        {
            $definition = $container->getDefinition($id);
            $definition->addArgument(new Reference('doctrine'));
            $definition->addArgument($attributes[0]['entity']);
        }
    }

}