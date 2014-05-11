<?php

namespace HCLabs\ModelManagerBundle\Tests;

use HCLabs\ModelManagerBundle\Model\Contract\ModelInterface;

class TestEntity implements ModelInterface
{
    /** @var string */
    private $name;

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getName() == null ? 'New TestEntity' : $this->getName();
    }
}