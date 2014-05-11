<?php

namespace HCLabs\ModelManagerBundle\Model\Contract;

interface ModelOperationsInterface
{
    /**
     * Create a model instance
     *
     * @return ModelInterface
     */
    public function create();

    /**
     * Remove model from database
     *
     * @param  ModelInterface $model
     * @return $this
     */
    public function remove(ModelInterface $model);

    /**
     * Persist model to database
     *
     * @param  ModelInterface $model
     * @return $this
     */
    public function persist(ModelInterface $model);

    /**
     * Flush entity manager
     *
     * @return mixed
     */
    public function flush();
}