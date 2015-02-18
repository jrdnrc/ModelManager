<?php

namespace HCLabs\ModelManagerBundle;

use HCLabs\ModelManagerBundle\DependencyInjection\CompilerPass\ModelManagerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class HCLabsModelManagerBundle
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 * @deprecated
 *
 * I would recommend using the repository pattern over this model
 * management bundle.
 */
class HCLabsModelManagerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ModelManagerCompilerPass());
    }
}
