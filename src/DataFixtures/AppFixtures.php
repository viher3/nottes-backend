<?php

  namespace App\DataFixtures;

  use Doctrine\Bundle\FixturesBundle\Fixture;
  use Doctrine\Common\Persistence\ObjectManager;
  use Symfony\Component\DependencyInjection\ContainerInterface;
  use Symfony\Component\DependencyInjection\ContainerAwareInterface;

  use App\Entity\Notte;

  class AppFixtures extends Fixture implements ContainerAwareInterface
  {
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
      $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
      $userManager  = $this->container->get('fos_user.user_manager');
      $user         = $this->createTestUser($manager, $userManager);
      $this->createTestNote($manager, $user);
    }

    private function createTestUser(ObjectManager $manager, $userManager)
    {
      $user = $userManager->createUser();
      $user->setUsername('phpunit');
      $user->setEmail('phpunit@domain.com');
      $user->setPlainPassword('1234');
      $user->setEnabled(true);

      $manager->persist($user);
      $manager->flush();

      return $user;
    }

    private function createTestNote(ObjectManager $manager, $user)
    {
      $notte = new Notte();
    
      $notte->setName("test-name");
      $notte->setContent("test-content");
      $notte->setTags("test-tags");
      $notte->setIsEncrypted(false);

      $manager->persist($notte);
      $manager->flush();

      return $notte;
    }

  }
