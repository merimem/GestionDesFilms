<?php

namespace GestionFilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GestionFilmsBundle\Entity\Acteur;
use GestionFilmsBundle\Form\ActeurType;
use Symfony\Component\HttpFoundation\Response;

class ActeurController extends Controller
{
    public function ajoutAction()
    {
        $message="Ajouter un acteur";
        $em=$this->getDoctrine()->getManager();

        $Acteur = new Acteur();
        $form=$this->createForm(new ActeurType(), $Acteur);

        $request=$this->getRequest();

        if($request->getMethod()=='POST'){
            $form->handleRequest($request); //pour recpuperer les donnees

            if($form->isValid()){
                $em->persist($Acteur);
                $em->flush();
                //$message="Acteur a été ajouté avec succès";
            }
            return $this->redirectToRoute('acteur_affiche');
        }

        return $this->render('GestionFilmsBundle:Acteur:edit.html.twig', array(
            'form'=>$form->createView(),
             'msg'=>$message,
        )
        );
    }

    public function afficheAction()
    {
        $em=$this->getDoctrine()->getManager();
        $acteurs=$em->getRepository('GestionFilmsBundle:Acteur')->findAll();
        return $this->render('GestionFilmsBundle:Acteur:afficheActeurs.html.twig', array('act'=>$acteurs));

    }


    public function modifAction($id)
{
    $message="Modifier un acteur";
    $em=$this->getDoctrine()->getManager();

    $Acteur = $em->getRepository('GestionFilmsBundle:Acteur')->find($id);
    $form=$this->createForm(new ActeurType(), $Acteur);

    $request=$this->getRequest();

    if($request->getMethod()=='POST'){
        $form->handleRequest($request); //pour recpuperer les donnees

        if($form->isValid()){

            $em->flush();
            $message="Acteur a été ajouté avec succès";

        }
        return $this->redirectToRoute('acteur_affiche');
    }



    return $this->render('GestionFilmsBundle:Acteur:edit.html.twig', array(
            'form'=>$form->createView(),
            'msg'=>$message,
        )
    );
}
    public function suppAction($id){

        $em=$this->getDoctrine()->getManager();

        $Acteur = $em->find('GestionFilmsBundle:Acteur',$id);
        if(!$Acteur){
            throw $this->createNotFoundException('Acteur avec lid'.$id.'n\'existe pas');       }
        $em->remove($Acteur);
        $em->flush();
        return $this->redirectToRoute('acteur_affiche');
    }
}
