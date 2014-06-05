<?php

namespace HCLabs\ModelManagerBundle\Tests;

use HCLabs\ModelManagerBundle\Model\Contract\ModelInterface;

class TestNonManagedEntity implements ModelInterface
{
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return '';
    }

}