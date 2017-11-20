<?php
/**
 * Created by PhpStorm.
 * User: Meriem
 * Date: 13/05/2016
 * Time: 20:59
 */


namespace GestionFilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GestionFilmsBundle\Entity\Categorie;

class CategorieController extends Controller
{

    public function ajoutAction()
    {
        $em=$this->getDoctrine()->getManager();
        $categorie = new Categorie();
        $categorie->setNom('romance');
        $em->persist($categorie);


        $categorie1 = new Categorie();
        $categorie1->setNom('action');
        $em->persist($categorie1);


        $categorie2 = new Categorie();
        $categorie2->setNom('thriller');
        $em->persist($categorie2);
        $em->flush();



        return $this->render('GestionFilmsBundle:Categorie:ajout.html.twig');
    }
    public function afficheAction()
    {
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository('GestionFilmsBundle:Categorie')->findAll();
        return $this->render('GestionFilmsBundle:Categorie:affiche.html.twig', array('catg'=>$categories));
    }
}
