<?php

namespace HCLabs\ModelManagerBundle\Model\Contract;

interface ModelInterface
{
    /**
     * Provide string representation of a model
     *
     * @return string
     */
    public function __toString();
}