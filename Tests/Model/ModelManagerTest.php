<?php

namespace HCLabs\ModelManagerBundle\Tests;

use HCLabs\ModelManagerBundle\Model\ModelManager;

class ModelManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    protected $entity;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $em;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $repository;

    /** @var ModelManager */
    protected $manager;

    public function setUp()
    {
        $this->entity     = "\\HCLabs\\ModelManagerBundle\\Tests\\TestEntity";
        $this->em         = $this->getMockBuilder("Doctrine\\ORM\\EntityManagerInterface")->disableOriginalConstructor()->getMockForAbstractClass();
        $this->repository = $this->getMockBuilder("Doctrine\\ORM\\EntityRepository")->disableOriginalConstructor()->getMock();
        $this->manager    = new ModelManager($this->em, $this->entity);
    }

    /**
     * @covers \HCLabs\ModelManagerBundle\Model\ModelManager::create
     */
    public function testCreate()
    {
        $entity = $this->manager->create();

        $this->assertInstanceOf($this->entity, $entity);
    }

    /**
     * @covers \HCLabs\ModelManagerBundle\Model\ModelManager::create
     */
    public function testCreateWithData()
    {
        /** @var \HCLabs\ModelManagerBundle\Tests\TestEntity $entity */
        $entity = new $this->entity();

        $entity->setName('test');

        $createdEntity = $this->manager->create(['name' => 'test']);

        $this->assertEquals($entity, $createdEntity);
    }

    /**
     * @covers \HCLabs\ModelManagerBundle\Model\ModelManager::create
     * @expectedException \HCLabs\ModelManagerBundle\Exception\MethodNotFoundException
     */
    public function testCreateWithBadDataThrowsException()
    {
        $this->manager->create(['lol' => 'test']);
    }

    /**
     * @covers \HCLabs\ModelManagerBundle\Model\ModelManager::persist
     */
    public function testPersist()
    {
        $entity = $this->manager->create();

        $this->em->expects($this->once())
                 ->method('persist')
                 ->with($entity);

        $result = $this->manager->persist($entity);

        $this->assertSame($this->manager, $result);
    }

    /**
     * @covers \HCLabs\ModelManagerBundle\Model\ModelManager::remove
     */
    public function testRemove()
    {
        $entity = $this->manager->create();

        $this->em->expects($this->once())
                 ->method('remove')
                 ->with($entity);

        $result = $this->manager->remove($entity);

        $this->assertSame($this->manager, $result);
    }

    /**
     * @covers \HCLabs\ModelManagerBundle\Model\ModelManager::flush
     */
    public function testFlush()
    {
        $this->em->expects($this->once())
                 ->method('flush');

        $this->manager->flush();
    }

    /**
     * @covers \HCLabs\ModelManagerBundle\Model\ModelManager::repository
     */
    public function testRepository()
    {
        $this->provideRepository();

        $result = $this->manager->repository();

        $this->assertSame($this->repository, $result);
    }

    /**
     * @covers \HCLabs\ModelManagerBundle\Model\ModelManager::findOrFail
     */
    public function testFindOrFail()
    {
        $this->provideRepository();

        $entity = $this->manager->create();

        $this->repository->expects($this->once())
                         ->method('findOneBy')
                         ->with(array())
                         ->willReturn($entity);

        $result = $this->manager->findOrFail(array());

        $this->assertSame($entity, $result);
    }

    /**
     * @covers \HCLabs\ModelManagerBundle\Model\ModelManager::findOrFail
     * @expectedException \Doctrine\ORM\EntityNotFoundException
     */
    public function testFindOrFailThrowsEntityNotFoundException()
    {
        $this->provideRepository();

        $this->repository->expects($this->once())
                         ->method('findOneBy')
                         ->with(array())
                         ->willReturn(null);

        $this->manager->findOrFail(array());
    }

    /**
     * @covers \HCLabs\ModelManagerBundle\Model\ModelManager::find
     */
    public function testFind()
    {
        $entity1 = $this->manager->create();
        $entity2 = $this->manager->create();

        $this->provideRepository();

        $this->repository->expects($this->once())
                         ->method('findBy')
                         ->with(array())
                         ->willReturn([$entity1, $entity2]);

        $result = $this->manager->find(array());

        $this->assertEquals([$entity1, $entity2], $result);
    }

    /**
     * @return void
     */
    protected function provideRepository()
    {
        $this->em->expects($this->once())
                 ->method('getRepository')
                 ->with($this->entity)
                 ->willReturn($this->repository);
    }
}