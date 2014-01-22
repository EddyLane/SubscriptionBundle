<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 21/01/2014
 * Time: 22:19
 */

use Fridge\SubscriptionBundle\Manager\BaseManager;


class BaseMangerTest extends AbstractBaseManagerTest
{
    public function setUp()
    {
        $this->baseManager = new BaseManager(
            'stdClass'
        );
    }

    public function testConstructorSetsClassName()
    {
        $this->assertEquals('stdClass', $this->baseManager->getClassName());
    }

    public function testGetEntityManagerFunction()
    {
        $doctrineMock = $this->getDoctrineRegistryMock();

        $entityManager = $this->getDoctrineManagerMock();

        $doctrineMock->expects($this->atLeastOnce())
            ->method('getManager')
            ->will($this->returnValue($entityManager))
        ;

        $this->baseManager->setDoctrine($doctrineMock);

        $this->assertEquals($entityManager, $this->baseManager->getEntityManager());
    }

    public function testGetRepositoryWithACustomRepositoryFunction()
    {
        $repositoryMock = $this->getGenericRepositoryMock();

        $this->baseManager->setRepository($repositoryMock);

        $this->assertEquals($repositoryMock, $this->baseManager->getRepository());
    }

    public function testGetRepositoryWithAGenericRepositoryFunction()
    {
        $doctrineMock = $this->getDoctrineRegistryMock();

        $entityManager = $this->getDoctrineManagerMock();

        $repositoryMock = $this->getGenericRepositoryMock();

        $entityManager->expects($this->once())
            ->method('getRepository')
            ->with('stdClass')
            ->will($this->returnValue($repositoryMock))
        ;

        $doctrineMock->expects($this->atLeastOnce())
            ->method('getManager')
            ->will($this->returnValue($entityManager))
        ;

        $this->baseManager->setDoctrine($doctrineMock);

        $this->assertEquals($repositoryMock, $this->baseManager->getRepository());
    }

    public function testSetClassName()
    {
        $this->baseManager->setClassName('NewEntity');
        $this->assertEquals('NewEntity', $this->baseManager->getClassName());
    }

    public function testCreationNoParameters()
    {
        $result = $this->baseManager->create();
        $this->assertEquals('stdClass', get_class($this->baseManager->create()));
    }

    public function testCreationWithParameters()
    {
        $this->baseManager->setClassName('Fridge\SubscriptionBundle\Manager\BaseManager');
        $result = $this->baseManager->create('TestClass');
        $this->assertEquals('TestClass', $result->getClassName());
    }

    /**
     * @expectedException \Exception
     */
    public function testSaveInvalidClass()
    {
        $this->baseManager->setClassName('Fridge\SubscriptionBundle\Manager\BaseManager');
        $this->baseManager->save(new stdClass());
    }
    /**
     * @expectedException \Exception
     */
    public function testRemoveInvalidClass()
    {
        $this->baseManager->setClassName('Fridge\SubscriptionBundle\Manager\BaseManager');
        $this->baseManager->remove(new stdClass());
    }

    public function testSaveValidClassWithoutFlush()
    {
        $doctrineMock = $this->getDoctrineRegistryMock();

        $entityManager = $this->getDoctrineManagerMock();

        $subject = new stdClass();

        $doctrineMock->expects($this->atLeastOnce())
            ->method('getManager')
            ->will($this->returnValue($entityManager))
        ;

        $entityManager->expects($this->once())
            ->method('persist')
            ->with($subject)
        ;

        $this->baseManager->setDoctrine($doctrineMock);

        $this->baseManager->save($subject);
    }


    public function testSaveValidClassWithFlush()
    {
        $doctrineMock = $this->getDoctrineRegistryMock();

        $entityManager = $this->getDoctrineManagerMock();

        $subject = new stdClass();

        $doctrineMock->expects($this->atLeastOnce())
            ->method('getManager')
            ->will($this->returnValue($entityManager))
        ;

        $entityManager->expects($this->once())
            ->method('persist')
            ->with($subject)
        ;
        $entityManager->expects($this->once())
            ->method('flush')
        ;

        $this->baseManager->setDoctrine($doctrineMock);

        $this->baseManager->save($subject, true);
    }

    public function testRemoveValidClassWithoutFlush()
    {
        $doctrineMock = $this->getDoctrineRegistryMock();

        $entityManager = $this->getDoctrineManagerMock();

        $subject = new stdClass();

        $doctrineMock->expects($this->atLeastOnce())
            ->method('getManager')
            ->will($this->returnValue($entityManager))
        ;

        $entityManager->expects($this->once())
            ->method('remove')
            ->with($subject)
        ;

        $this->baseManager->setDoctrine($doctrineMock);

        $this->baseManager->remove($subject);
    }


    public function testRemoveValidClassWithFlush()
    {
        $doctrineMock = $this->getDoctrineRegistryMock();

        $entityManager = $this->getDoctrineManagerMock();

        $subject = new stdClass();

        $doctrineMock->expects($this->atLeastOnce())
            ->method('getManager')
            ->will($this->returnValue($entityManager))
        ;

        $entityManager->expects($this->once())
            ->method('remove')
            ->with($subject)
        ;
        $entityManager->expects($this->once())
            ->method('flush')
        ;

        $this->baseManager->setDoctrine($doctrineMock);

        $this->baseManager->remove($subject, true);
    }

    public function testClearFunction()
    {
        $doctrineMock = $this->getDoctrineRegistryMock();

        $entityManager = $this->getDoctrineManagerMock();

        $doctrineMock->expects($this->atLeastOnce())
            ->method('getManager')
            ->will($this->returnValue($entityManager))
        ;

        $entityManager->expects($this->once())
            ->method('clear');

        $this->baseManager->setDoctrine($doctrineMock);

        $this->baseManager->clear();
    }

    public function testMergeFunction()
    {
        $doctrineMock = $this->getDoctrineRegistryMock();

        $entityManager = $this->getDoctrineManagerMock();
        $subject = new stdClass();

        $doctrineMock->expects($this->atLeastOnce())
            ->method('getManager')
            ->will($this->returnValue($entityManager))
        ;

        $entityManager->expects($this->once())
            ->method('merge')
            ->with($subject)
        ;

        $this->baseManager->setDoctrine($doctrineMock);

        $this->baseManager->merge($subject);
    }

    public function testFindFunction()
    {
        $doctrineMock = $this->getDoctrineRegistryMock();

        $entityManager = $this->getDoctrineManagerMock();
        $expection = new stdClass();

        $doctrineMock->expects($this->atLeastOnce())
            ->method('getManager')
            ->will($this->returnValue($entityManager))
        ;

        $repositoryMock = $this->getGenericRepositoryMock();

        $repositoryMock->expects($this->once())
            ->method('find')
            ->with(1)
            ->will($this->returnValue($expection))
        ;

        $entityManager->expects($this->once())
            ->method('getRepository')
            ->with('stdClass')
            ->will($this->returnValue($repositoryMock))
        ;
        $this->baseManager->setDoctrine($doctrineMock);

        $this->assertEquals($expection, $this->baseManager->find(1));
    }

    public function testFindAllFunction()
    {
        $doctrineMock = $this->getDoctrineRegistryMock();

        $entityManager = $this->getDoctrineManagerMock();
        $expection = [new stdClass()];

        $doctrineMock->expects($this->atLeastOnce())
            ->method('getManager')
            ->will($this->returnValue($entityManager))
        ;

        $repositoryMock = $this->getGenericRepositoryMock();

        $repositoryMock->expects($this->once())
            ->method('findAll')
            ->will($this->returnValue($expection))
        ;

        $entityManager->expects($this->once())
            ->method('getRepository')
            ->with('stdClass')
            ->will($this->returnValue($repositoryMock))
        ;
        $this->baseManager->setDoctrine($doctrineMock);

        $this->assertEquals($expection, $this->baseManager->findAll());
    }

    public function testFindOneByFunction()
    {
        $doctrineMock = $this->getDoctrineRegistryMock();

        $entityManager = $this->getDoctrineManagerMock();
        $expection = new stdClass();

        $doctrineMock->expects($this->atLeastOnce())
            ->method('getManager')
            ->will($this->returnValue($entityManager))
        ;

        $repositoryMock = $this->getGenericRepositoryMock();

        $repositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with([ 'id' => 1 ])
            ->will($this->returnValue($expection))
        ;

        $entityManager->expects($this->once())
            ->method('getRepository')
            ->with('stdClass')
            ->will($this->returnValue($repositoryMock))
        ;
        $this->baseManager->setDoctrine($doctrineMock);

        $this->assertEquals($expection, $this->baseManager->findOneBy([
            'id' => 1
        ]));
    }
}