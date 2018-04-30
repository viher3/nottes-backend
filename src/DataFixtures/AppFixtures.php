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
      $user         = $this->createTestUser($manager, $userManager, 'phpunit');
      $user2        = $this->createTestUser($manager, $userManager, 'phpunit2');

      $this->createTestNote($manager, $user, "test-name", "test-content", "test-tags");
      $this->createTestNote($manager, $user, "lorem ipsum", "lorem ipsum", "lorem,ipsum");
      $this->createTestNote($manager, $user2, "lorem ipsum user 2", "lorem ipsum user 2", "lorem,ipsum");
    }

    private function createTestUser(ObjectManager $manager, $userManager, $username)
    {
      $user = $userManager->createUser();
      $user->setUsername($username);
      $user->setEmail($username . '@domain.com');
      $user->setPlainPassword('1234');
      $user->setLanguage('en');
      $user->setEnabled(true);

      $manager->persist($user);
      $manager->flush();

      return $user;
    }

    private function createTestNote(ObjectManager $manager, $user, $name, $content, $tags)
    {
      $notte = new Notte();
    
      $notte->setName($name);
      $notte->setContent($content);
      $notte->setTags($tags);
      $notte->setIsEncrypted(false);
      $notte->setCreatorUser($user);

      $manager->persist($notte);
      $manager->flush();

      return $notte;
    }

  }
