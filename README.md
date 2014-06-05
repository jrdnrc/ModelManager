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

        "hclabs/model-manager-bundle": "dev-master"
    }

Service Definitions:

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

Example Entity:

    <?php
    // src/Acme/AcmeDemoBundle/Entity/TestEntity

    class TestEntity
    {
        /**
         * @var string
         */
        private $name;

        /**
         * @var bool
         */
        private $enabled;

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
         * Set enabled
         *
         * @param bool $enabled
         */
        public function setEnabled($enabled)
        {
            $this->enabled = $enabled;
        }

        // ... getters
    }

Example Controller:

    <?php
	// src/Acme/AcmeDemoBundle/Controller/DemoController.php

	use HCLabs\ModelManagerBundle\Model\Contract\ModelManagerInterface;

	class DemoController
	{
    	protected $manager;
    
		public function indexAction()
    	{
    	    /** @var string[] $criteria */
    	    $criteria = ['name' => 'test'];

        	try {
	        	$entity = $this->manager->findOrFail($criteria);
		    }
		    catch(EntityNotFoundException $e) {
		        $entity = $this->manager->create($criteria);
		    }
	    
		    $entity->setEnabled(1);
	    
		    $this->manager->persist($entity)->flush();

		    // some other stuff....
	    
	    }

	    public function setTestModelManager(ModelManagerInterface $modelManager)
		{
			$this->manager = $modelManager;
		}
	}

New:
====

The admin pool:

You can make use of the admin pool to get a manager for any managed entity. E.g.:

    <?php
    // src/Acme/AcmeDemoBundle/Controller/DemoController.php
    
    use Symfony\Component\HttpFoundation\Request;
    use HCLabs\ModelManagerBundle\Pool\ModelManagerPool;
    
    class DemoController
    {
        protected $pool;
        
        protected $formFactory;
        
        protected $twig;
        
        public function updateUserAction(Request $request)
        {
            $form = $this->formFactory->create('my_form_type');
            $form->handleRequest($request);
            
            if ($form->isValid()) {
            	$manager = $this->pool->getManager($form->getData());
            	
            	$manager->persist($user)->flush();
            	
            	return $this->twig->render(
            		'AcmeDemoBundle:Demo:update-success.html.twig',
            		['user' => $user]
            	);
            }
            
            return $this->twig->render(
            	'AcmeDemoBundle:Demo:edit.html.twig',
            	['form' => $form]
            );
        }
               
        public function setModelManagerPool(ModelManagerPool $pool)
        {
            $this->pool = $pool;
        }
        
        // Other service setters ...
    }