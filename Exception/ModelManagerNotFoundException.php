<?php

namespace HCLabs\ModelManagerBundle\Exception;

class ModelManagerNotFoundException extends \Exception
{
    public function __construct($class = null)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $message = sprintf('Model Manager for class \'%s\' not found.', $class);

        parent::__construct($message);
    }
}