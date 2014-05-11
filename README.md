HCLabs Model Manager
====================

[![Build Status](https://travis-ci.org/jrdnhannah/ModelManager.svg?branch=master)](https://travis-ci.org/jrdnhannah/ModelManager)

A simple model manager.

<hr />

Usage:
======

Add to your `composer.json` file:

    "require": {
        // ...

        "hclabs/model-manager-bundle": "1.0.0-RC2"
    }
&nbsp;

	# src/Acme/AcmeDemoBundle/Resources/config/services.yml

	parameters:
    	acme.demo_entity.class:     "Acme\\DemoBundle\\Entity\\TestEntity"
	    hclabs.model_manager.class: "HCLabs\\ModelManagerBundle\\Model\\ModelManager"
    
    	acme.demo_controller.class: "Acme\\DemoBundle\\Controller\\DemoController"

	services:
    	acme.demo_model_manager:
        	class: "%hclabs.model_manager.class%"
	        tags:
	            - { name: hclabs.model_manager, entity: "%acme.demo_entity.class%" }
    
	    acme.demo_controller:
	        class: "%acme.demo_controller%"
	        calls:
	            - [setTestModelManager, ["@acme.demo_model_manager"]]


&nbsp;

	// src/Acme/AcmeDemoBundle/Controller/DemoController.php

	use HCLabs\ModelManagerBundle\Model\Contract\ModelManagerInterface

	class DemoController
	{
    	protected $manager;
    
		public function indexAction()
    	{
        	try {
	        	$entity = $this->manager->findOrFail(array('name' => 'test'));
		    }
		    catch(EntityNotFoundException $e) {
		        $entity = $this->manager->create();
		        $entity->setName('test');
		    }
	    
		    $entity->setEnabled(1);
	    
		    $this->manager->persist($entity)->flush();	    
	    
	    }

	    public function setTestModelManager(ModelManagerInterface $modelManager)
		{
			$this->manager = $modelManager;
		}
	}