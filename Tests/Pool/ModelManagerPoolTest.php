<?php

namespace HCLabs\ModelManagerBundle\Tests\Pool;

use HCLabs\ModelManagerBundle\Model\ModelManager;
use HCLabs\ModelManagerBundle\Pool\ModelManagerPool;

class ModelManagerPoolTest extends \PHPUnit_Framework_TestCase
{
    /** @var ModelManagerPool */
    protected $pool;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $registry;

    public function setUp()
    {
        $this->registry   = $this->getMockBuilder(
            "Doctrine\\Bundle\\DoctrineBundle\\Registry"
        )->disableOriginalConstructor()->getMock();

        $this->pool = new ModelManagerPool;
    }

    /**
     * @covers \HCLabs\ModelManagerBundle\Pool\ModelManagerPool::addManager
     */
    public function testAddManager()
    {
        $manager1 = new ModelManager($this->registry, 'HCLabs\ModelManagerBundle\Tests\TestEntity');

        $managers = new \ReflectionProperty($this->pool, 'managers');
        $managers->setAccessible(true);

        $this->pool->addManager($manager1);

        $this->assertEquals([$manager1], $managers->getValue($this->pool));
    }

    /**
     * @covers \HCLabs\ModelManagerBundle\Pool\ModelManagerPool::getManager
     */
    public function testGetManager()
    {
        $manager1 = new ModelManager($this->registry, 'HCLabs\ModelManagerBundle\Tests\TestEntity');
        $manager2 = new ModelManager($this->registry, 'HCLabs\ModelManagerBundle\Tests\TestNonManagedEntity');

        $this->pool->addManager($manager1);
        $this->pool->addManager($manager2);

        $poolManager1 = $this->pool->getManager(new \HCLabs\ModelManagerBundle\Tests\TestEntity);
        $poolManager2 = $this->pool->getManager(new \HCLabs\ModelManagerBundle\Tests\TestNonManagedEntity);

        $this->assertSame($manager1, $poolManager1);
        $this->assertSame($manager2, $poolManager2);
    }

    /**
     * @covers \HCLabs\ModelManagerBundle\Pool\ModelManagerPool::getManager
     * @expectedException \HCLabs\ModelManagerBundle\Exception\ModelManagerNotFoundException
     */
    public function testGetManagerThrowsExceptionIfNotFound()
    {
        $manager = new ModelManager($this->registry, 'HCLabs\ModelManagerBundle\Tests\TestEntity');
        $this->pool->addManager($manager);

        $this->pool->getManager(new \HCLabs\ModelManagerBundle\Tests\TestNonManagedEntity);
    }
}