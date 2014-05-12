<?php

namespace HCLabs\ModelManagerBundle\Model;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use HCLabs\ModelManagerBundle\Exception\BadImplementationException;
use HCLabs\ModelManagerBundle\Exception\MethodNotFoundException;
use HCLabs\ModelManagerBundle\Model\Contract\ModelInterface;
use HCLabs\ModelManagerBundle\Model\Contract\ModelManagerInterface;

class ModelManager implements ModelManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * The entity class name
     *
     * @var string
     */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em, $modelClass)
    {
        $modelInterface = '\\HCLabs\\ModelManagerBundle\\Model\\Contract\\ModelInterface';

        if(!is_a($modelClass, $modelInterface, true)) {
            throw new BadImplementationException($modelInterface, $modelClass);
        }

        $this->em    = $em;
        $this->model = $modelClass;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data = array())
    {
        $model = new $this->model();

        if(empty($data)) {
            return $model;
        }

        $setFormat = 'set%s';

        foreach($data as $attr => $value) {
            $attr      = ucfirst($attr);
            $setMethod = sprintf($setFormat, $attr);

            if(method_exists($model, $setMethod)) {
                $model->$setMethod($value);
            }
            else {
                throw new MethodNotFoundException($setMethod, $model);
            }
        }

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(ModelInterface $model)
    {
        $this->em->remove($model);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function persist(ModelInterface $model)
    {
        $this->em->persist($model);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function repository()
    {
        return $this->em->getRepository($this->model);
    }

    /**
     * {@inheritdoc}
     */
    public function findOrFail(array $criteria)
    {
        $entity = $this->repository()->findOneBy($criteria);

        if(is_null($entity)) {
            throw new EntityNotFoundException;
        }

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function find(array $criteria)
    {
        return $this->repository()->findBy($criteria);
    }
}