<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=1; $i<=10; $i++)
        {
          $article = new Article;

          $article->setTitle("Titre de l'article n° $i")
                  ->setContent("<p>Contenu de l'article n° $i</p>")
                  ->setImage("https://picsum.photos/250")
                  ->setCreatedAt(new\ DateTime());

          $manager->persist($article);        
        }

        $manager->flush();
    }
}
