<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    //un commentaire qui commence avec un @ est une annotation très importante, symfony exlique que lorqu'on lancera www.monsite.com/blog, on fera appel à la methode index()
    //Pas besion de préciser template/blog/index.html.twig,symfony sait ou se trouve les fichiers templates du rendu
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
    /**
 * @route("/",name="home")
 */

 public function home()
 {
     return $this->render('blog/home.twig');
 }
}
