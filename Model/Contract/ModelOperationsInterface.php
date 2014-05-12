<?php

namespace HCLabs\ModelManagerBundle\Model\Contract;

interface ModelOperationsInterface
{
    /**
     * Create a model instance
     *
     * @param  array $data
     * @throws \HCLabs\ModelManagerBundle\Exception\MethodNotFoundException
     * @return ModelInterface
     */
    public function create(array $data = array());

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