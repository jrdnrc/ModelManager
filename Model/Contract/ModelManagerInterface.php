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
     */
    public function __construct(EntityManagerInterface $em, $modelClass);
}