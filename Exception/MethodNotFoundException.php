<?php

namespace HCLabs\ModelManagerBundle\Exception;

class MethodNotFoundException extends \Exception
{
    /**
     * @param string                                                   $method
     * @param \HCLabs\ModelManagerBundle\Model\Contract\ModelInterface $object
     */
    public function __construct($method, $object)
    {
        $message = sprintf("Method '%s' not found in object type '%s'", $method, get_class($object));
        parent::__construct($message);
    }
}