<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BlogController extends AbstractController
{
    //un commentaire qui commence avec un @ est une annotation très importante, symfony exlique que lorqu'on lancera www.monsite.com/blog, on fera appel à la methode index()
    //Pas besion de préciser template/blog/index.html.twig,symfony sait ou se trouve les fichiers templates du rendu
    
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {

        /*
            Pour selectionner des données en BDD, nous avons besoin de la classe Repository de la classe Article
            Une classe Repository permet uniquement de selectionner des données en BDD (requete SQL SELECT)
            On a besoin de l'ORM DOCTRINE pour faire la relation entre la BDD et notre application (getDoctrine())
            getRepository() : méthode issue de l'objet DOCTRINE qui permet d'importer une classe Repository (SELECT)

            $repo est un objet issu de la classe ArticleRepository, cette contient des méthodes prédéfinies par SYMFONY permettant de selectionner des données en BDD (find, findBy, findOneBy, findAll)

            dump() : équivalent de var_dump(), permet d'observer le resultat de la requete de selection en bas de la page dans la barre administrative (cible à droite)
        */
       // findAll() est une méthode issue de la classe ArticleRepository qui permet de selectionner l'ensemble de la table (similaire à SELECT * FROM article)
 
        //$repo =$this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        
        dump($articles);

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' =>$articles
        ]);

        //on envois les articles selectionnés en BDD directement sur le navigateur dans le template index.html.twig
    }
    /**
 * @route("/",name="home")
 */

 public function home()
 {
     return $this->render('blog/home.html.twig',[
         'title' => 'Bienvenue sur le blog SYMFONY',
         'age' => 25
     ]);
 }

  /**
     * @route("/blog/new",name="blog_create")
     * @route("/blog/{id}/edit",name="blog_edit")
   */
public function form(Article $article=null,  Request $request,EntityManagerInterface $manager)
{
    dump($request);

    // if($request->request->count() > 0)
    // {
    //     $article = new Article;
    //     $article->setTitle($request->request->get('title'))
    //             ->setContent($request->request->get('content'))
    //             ->setImage($request->request->get('image'))
    //             ->setCreatedAt(new \DateTime());

    //     $manager->persist($article);
    //     $manager->flush();    
        
    //     dump($article);

    //     return $this->redirectToRoute('blog_show',[
    //         'id' =>$article->getId()

    //     ]);
    // }

    if(!$article)
    {
        $article = new Article;
    }

    // $article->setTitle("titre à la con")
    //         ->setContent("Contenu de l'article à la con");
    
    $form = $this->createFormBuilder($article)

                 ->add('title')
                 ->add('content')

                 ->add('image')

                  
                 ->getForm();

      $form->handleRequest($request);  

      if($form->isSubmitted() && $form->isValid())     
        {
            if(!$article->getId())
            {
             $article->setCreatedAt(new \DateTime());
            }
            

            $manager->persist($article);
            $manager->flush();
            
            return $this->redirectToRoute('blog_show',[
                'id' => $article->getId()
                ]);
        }

    return $this->render('blog/create.html.twig',[
          'formArticle' => $form->createView()
    ]);
}

  
// show() : méthode permettant d'afficher le détail d'un article
             //45
 /**
  * @route("/blog/{id}",name="blog_show")
  */
  public function show(Article $article) //1
  {
      //$repo =$this->getDoctrine()->getRepository(Article::class);

      //$article = $repo->find($id);

      dump($article);

      return $this->render('blog/show.html.twig',[
             'article' => $article
      ]);
  }
 



}
