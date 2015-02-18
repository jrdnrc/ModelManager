<?php

namespace HCLabs\ModelManagerBundle\Model;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityNotFoundException;
use HCLabs\ModelManagerBundle\Exception\BadImplementationException;
use HCLabs\ModelManagerBundle\Exception\MethodNotFoundException;
use HCLabs\ModelManagerBundle\Model\Contract\ModelInterface;
use HCLabs\ModelManagerBundle\Model\Contract\ModelManagerInterface;

/**
 * Class ModelManager
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 * @deprecated
 */
class ModelManager implements ModelManagerInterface
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * The entity class name
     *
     * @var string
     */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function __construct(Registry $registry, $modelClass)
    {
        $modelInterface = '\\HCLabs\\ModelManagerBundle\\Model\\Contract\\ModelInterface';

        if (!is_a($modelClass, $modelInterface, true)) {
            throw new BadImplementationException($modelInterface, $modelClass);
        }

        $this->registry = $registry;
        $this->model    = $modelClass;
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
        $this->registry->getManagerForClass($this->model)->remove($model);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function persist(ModelInterface $model)
    {
        $this->registry->getManagerForClass($this->model)->persist($model);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush(ModelInterface $model = null)
    {
        $this->registry->getManagerForClass($this->model)->flush($model);
    }

    /**
     * {@inheritdoc}
     */
    public function repository()
    {
        return $this->registry->getManagerForClass($this->model)->getRepository($this->model);
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

    /**
     * {@inheritdoc}
     */
    public function supports($class)
    {
        return is_a($class, $this->model, true);
    }
}
