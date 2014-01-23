<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 21/01/2014
 * Time: 22:19
 */

use Fridge\SubscriptionBundle\Manager\StripeProfileManager;
use Fridge\SubscriptionBundle\Entity\StripeProfile;


class StripeProfileManagerTest extends AbstractBaseManagerTest
{

    public function setUp()
    {
        $this->baseManager = new StripeProfileManager(
            'StripeProfile'
        );
    }

    public function testFindOneByStripeId()
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
            ->with(['stripe_id' => 2])
            ->will($this->returnValue($expection))
        ;

        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($repositoryMock))
        ;

        $this->baseManager->setDoctrine($doctrineMock);

        $this->assertEquals($expection, $this->baseManager->findOneByStripeId(2));
    }

}