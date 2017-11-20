<?php

namespace GestionFilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GestionFilmsBundle\Entity\Film;
use GestionFilmsBundle\Form\FilmType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class FilmController extends Controller
{
    public function ajoutAction()
    {
        $message="Ajouter un film";
        $em=$this->getDoctrine()->getManager();

        $Film = new Film();
        $form=$this->createForm(new FilmType(), $Film);

        $request=$this->getRequest();

        if($request->getMethod()=='POST'){
            $form->handleRequest($request); //pour recpuperer les donnees

            if($form->isValid()){
                $em->persist($Film);
                $em->flush();
                //$message="Acteur a été ajouté avec succès";
            }
            return $this->redirect($this->generateURL('filmOne_affiche',array('id' =>$Film->getId())));
        }

        return $this->render('GestionFilmsBundle:Film:edit.html.twig', array(
                'form'=>$form->createView(),
                'msg'=>$message,
            )
        );
    }

    public function afficheAction()
    {
        $em=$this->getDoctrine()->getManager();
        $films=$em->getRepository('GestionFilmsBundle:Film')->findAll();
        return $this->render('GestionFilmsBundle:Film:afficheFilms.html.twig', array('act'=>$films));

    }


    public function modifAction($id)
    {
        $message="Modifier un film";
        $em=$this->getDoctrine()->getManager();

        $Film = $em->getRepository('GestionFilmsBundle:Film')->find($id);
        $form=$this->createForm(new FilmType(), $Film);

        $request=$this->getRequest();

        if($request->getMethod()=='POST'){
            $form->handleRequest($request); //pour recpuperer les donnees

            if($form->isValid()){

                $em->flush();
                $message="Film a été ajouté avec succès";

            }
            return $this->redirectToRoute('film_affiche');
        }
       return $this->render('GestionFilmsBundle:Film:edit.html.twig', array(
                'form'=>$form->createView(),
                'msg'=>$message,
            )
        );
    }
    
    
    public function suppAction(Film $film){

//        $form = $this->createDeleteForm($id);
 //       $request = $this->getRequest();

   //     $form->bind($this->getRequest());

     //   if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
       //     $entity = $em->getRepository('GestionFilmsBundle:Film')->find($id);

         //   if (!$entity) {
          //      throw $this->createNotFoundException('Unable to find Ingredient entity.');
            //}

            $em->remove($film);
            $em->flush();


        return $this->redirect($this->generateUrl('film_affiche'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
            ;
    }
    
    
    
    public function afficheOneAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $Film = $em->getRepository('GestionFilmsBundle:Film')->find($id);

        if(!$Film) {
            throw $this->createNotFoundException('Film avec lid' . $id . 'n\'existe pas');
        }


        return $this->render('GestionFilmsBundle:Film:afficheOne.html.twig', array('act'=>$Film));
    }
    
    public function createAction(Request $request){
        $entity = new Film();
        $form=$this->createForm(new FilmType(), $entity);
        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $entity->upload();
            $em->persist($entity);
            $em->flush();
            $this->redirect($this->generateURL('filmOne_affiche', array( 'entity' => $entity,
                'form'   => $form->createView()
            )));


        }
        return $this->render('GestionFilmsBundle:Film:afficheOne.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));

    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GestionFilmsBundle:Film')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find film entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->redirect($this->generateURL('filmOne_affiche', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView() ,  )));
    }

  

    public function searchAction($titre)
    {
        $em=$this->getDoctrine()->getManager();
        $Film = $em->getRepository('GestionFilmsBundle:Film')->find($titre);

        if(!$Film) {
            throw $this->createNotFoundException('Film avec le titre' . $titre . 'n\'existe pas');
        }


        return $this->render('GestionFilmsBundle:Film:afficheSearch.html.twig', array('film'=>$Film));

       
    }

    public function thrillerAction()
    {
        $em=$this->getDoctrine()->getManager();
        $films=$em->getRepository('GestionFilmsBundle:Film')->findBy(array('categorie_id' => '5'));
        return $this->render('GestionFilmsBundle:Film:afficheFilms.html.twig', array('act'=>$films));
        


    }
}
