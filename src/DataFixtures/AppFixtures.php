<?php

  namespace App\DataFixtures;

  use Doctrine\Bundle\FixturesBundle\Fixture;
  use Doctrine\Common\Persistence\ObjectManager;
  use Symfony\Component\DependencyInjection\ContainerInterface;
  use Symfony\Component\DependencyInjection\ContainerAwareInterface;

  use App\Entity\Notte;
  use App\Entity\Document;
  use App\Services\Encryption\Encryption;

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
      $this->createTestNote($manager, $user, "encrypted", "encrypted", "encrypted,doc", true, "123456");

      $this->createNoteWithDocument($manager, $user);
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

    private function createTestNote(
      ObjectManager $manager, 
      $user, 
      $name, 
      $content, 
      $tags, 
      $isEncrypted=false, 
      $encriptionPwd="1234"
    )
    {
      $notte = new Notte();
    
      if($isEncrypted)
      {
        $encryption = new Encryption();
        $content = $encryption->encrypt($content, $encriptionPwd);
      }

      $notte->setName($name);
      $notte->setContent($content);
      $notte->setTags($tags);
      $notte->setIsEncrypted($isEncrypted);
      $notte->setCreatorUser($user);

      $manager->persist($notte);
      $manager->flush();

      return $notte;
    }

    private function createNoteWithDocument($manager, $user)
    {
      $document = new Document();
      $document->setName("test.jpeg");
      $document->setPath(".gitkeep");
      $document->setSize(0);
      $document->setMimetype("text/plain");
      $document->setCreatorUser($user);

      $manager->persist($document);
      $manager->flush();

      $notte = new Notte();
      $notte->setName("test_doc");
      $notte->setCreatorUser($user);
      $notte->setDocument($document);

      $manager->persist($notte);
      $manager->flush();

      return $document;
    }

  }
