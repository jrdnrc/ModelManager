<?php

namespace HCLabs\ModelManagerBundle\Exception;

class BadImplementationException extends \Exception
{
    /**
     * @param string $interface
     * @param string $class
     */
    public function __construct($interface, $class)
    {
        $message = sprintf("Class '%s' does not implement '%s', and cannot be managed by this model manager.", $class, $interface);
        parent::__construct($message);
    }
}