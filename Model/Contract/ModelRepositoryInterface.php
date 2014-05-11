<?php

namespace HCLabs\ModelManagerBundle\Model\Contract;

interface ModelRepositoryInterface
{
    /**
     * Return an instance of the repository for the model
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function repository();

    /**
     * Finds model instance based on $criteria
     *
     * @param array $criteria
     * @throws \Doctrine\ORM\EntityNotFoundException
     * @return ModelInterface
     */
    public function findOrFail(array $criteria);

    /**
     * Find a collection of model instances based on $criteria
     *
     * @param array $criteria
     * @return ModelInterface[]
     */
    public function find(array $criteria);
}