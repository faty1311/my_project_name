<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Article;
use App\Entity\Comment;
use app\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker =\Faker\Factory::create('fr_FR');

        for($i=1; $i<=3; $i++)
        {
         $category = new Category;
         $category->setTitle($faker->sentence())
                  ->setDescription($faker->paragraph());
                  
                  $manager->persist($category);
                   //creation de 4 à 6 articles
                  for($j = 1; $j<=mt_rand(4,6);$j++)
                  {
                    $article = new Article;
         
                    $content ='<p>'.join($faker->paragraphs(5),'</p><p>') .'</p>';

                    $article->setTitle($faker->sentence())
                            ->setContent($content)
                            ->setImage($faker->imageUrl())
                            ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                            ->setCategory($category);

                    $manager->persist($article);
                    
                    //creation de 4 à 10 commentaires
                    for($k = 1; $k<=mt_rand(4,6);$k++)
                    {
                      $comment = new Comment;
           
                      $content ='<p>'.join($faker->paragraphs(2),'</p><p>') .'</p>';

                      $now = new \DateTime();
                      $interval = $now->diff($article->getCreatedAt());
                      $days = $interval->days;
                      $minimum = '-' . $days .'days'; /* -100 days */
  
                      $comment->setAuthor($faker->name)
                              ->setContent($content)
                              ->setCreatedAt($faker->dateTimeBetween($minimum))
                              ->setArticle($article);
                         
  
                      $manager->persist($comment);
                    }  
                  }
        }

     $manager->flush();

    }
}
