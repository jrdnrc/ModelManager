<?php

namespace HCLabs\ModelManagerBundle\Model\Contract;

use Doctrine\ORM\EntityManagerInterface;

interface ModelManagerInterface extends ModelOperationsInterface, ModelRepositoryInterface
{
    /**
     * ModelManager constructor
     *
     * @param EntityManagerInterface $em
     * @param string                 $modelClass
     * @throws \HCLabs\ModelManagerBundle\Exception\BadImplementationException
     */
    public function __construct(EntityManagerInterface $em, $modelClass);
}