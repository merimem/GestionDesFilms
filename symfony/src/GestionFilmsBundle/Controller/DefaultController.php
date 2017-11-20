<?php

namespace GestionFilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function accueilAction()
    {
        return $this->render('GestionFilmsBundle::index.html.twig');
    }
    public function entretienAction()
    {
        return $this->render('GestionFilmsBundle::entretien.html.twig');
    }
    public function seriousgameAction()
    {
        return $this->render('GestionFilmsBundle::seriousgame.html.twig');
    }
    public function reseauAction()
    {
        return $this->render('GestionFilmsBundle::reseau.html.twig');
    }
}
