<?php

namespace HCLabs\ModelManagerBundle\Pool;

use HCLabs\ModelManagerBundle\Exception\ModelManagerNotFoundException;
use HCLabs\ModelManagerBundle\Model\Contract\ModelInterface;
use HCLabs\ModelManagerBundle\Model\Contract\ModelManagerInterface;

class ModelManagerPool
{
    /** @var ModelManagerInterface[] */
    protected $managers = [];

    /**
     * Add a model manager to the pool
     *
     * @param ModelManagerInterface $manager
     */
    public function addManager(ModelManagerInterface $manager)
    {
        $this->managers[] = $manager;
    }

    /**
     * Get manager for an entity out of the pool
     *
     * @param ModelInterface|string $model
     * @return ModelManagerInterface
     * @throws \HCLabs\ModelManagerBundle\Exception\ModelManagerNotFoundException
     * @throws \RuntimeException
     */
    public function getManager($model)
    {
        if (!is_string($model) && !$model instanceof ModelInterface) {
            throw new \RuntimeException(sprintf('Model provided (\'%s\') is neither a string nor an instance of ModelInterface', $model));
        }

        foreach ($this->managers as $manager) {
            if ($manager->supports($model)) {
                return $manager;
            }
        }

        throw new ModelManagerNotFoundException($model);
    }
}