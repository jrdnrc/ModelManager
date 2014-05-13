<?php

namespace HCLabs\ModelManagerBundle\Model\Contract;

use Doctrine\Bundle\DoctrineBundle\Registry;

interface ModelManagerInterface extends ModelOperationsInterface, ModelRepositoryInterface
{
    /**
     * ModelManager constructor
     *
     * @param Registry $registry
     * @param string   $modelClass
     * @throws \HCLabs\ModelManagerBundle\Exception\BadImplementationException
     */
    public function __construct(Registry $registry, $modelClass);
}