<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\User;

class ArticleFixtures extends Fixture
{

    private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }



    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');

        // création de 3 catégories

        $user = new User();
        $user->setUsername('Maina');
        $user->setEmail('valmaina@modulo.net');
        $user->setPassword($this->passwordEncoder->encodePassword(
             $user,
             'testtest'
         ));
        $user->setCreateAt(new  \DateTime());
        $user->setFirstname('Valérie');
        $user->setNumberAdr(77);
        $user->setAdress('rue Pasteur');
        $user->setVilleAdr('Bordeaux');
        $user->setCodePostal('33200');
        $user->setPseudo('sangria');





        for ($j=1; $j <= 5 ; $j++) {
          $category = new Category();
          $category->setTitle($faker->sentence())
                   ->setDescription($faker->paragraph());
          $manager->persist($category);

          // création de 4 à 6 articles

           for ($i=1; $i <= mt_rand(8, 10); $i++) {
             $article = new Article();
             $content = '<p>' . join('</p><p>' ,$faker->paragraphs(5)) . '</p>';
             $article->setTitle($faker->sentence())
                     ->setContent($content)
                     ->setAuthor($faker->name)
                     ->setAuthorId($faker->numberBetween(18, 20))
                     ->setImage($faker->imageUrl())
                     ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                     ->addCategory($category);
            $user->addArticle($article);
            $manager->persist($article);


             // ajout de commentaires
             for ($k=0; $k <= mt_rand(6, 8); $k++) {
                $comment = new Comment();
                $days = (new \DateTime())->diff($article->getCreatedAt())->days;
                $comment->setAuthor($faker->name)
                        ->setContent($faker->text(600))
                        ->setAuthorId($faker->numberBetween(17, 30))
                        ->setCreatedAt($faker->dateTimeBetween('-' . $days . 'days'))
                        ->setArticle($article);
                $manager->persist($comment);
             }
          }
        }

        $manager->persist($user);
        $manager->flush();
    }
}
