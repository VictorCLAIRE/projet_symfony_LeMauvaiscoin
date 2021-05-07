<?php

namespace App\Controller\SuperAdmin;

use App\Entity\Annonces;
use App\Entity\Categories;
use App\Entity\Regions;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuperAdminDashboardController extends AbstractDashboardController
{
    /**
     * @Route("/superadmin", name="superadmin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('LeMauvaisCoin Sf');

    }

    public function configureMenuItems(): iterable
    {
        return[
            MenuItem::linktoDashboard('Tableau de bord', 'fa fa-home'),

            MenuItem::section('Annonces'),
            MenuItem::linkToCrud('Annonces', 'fa fa-newspaper-o', Annonces::class),
            MenuItem::linkToUrl('Voir sur le site','fa fa-desktop', 'http://localhost:8000/annonces/'),

            MenuItem::section('Catégories'),
            MenuItem::linkToCrud('Catégories', 'fas fa-list', Categories::class),
            MenuItem::linkToUrl('Voir sur le site','fa fa-desktop', 'http://localhost:8000/categories/'),

            MenuItem::section('Régions'),
            MenuItem::linkToCrud('Régions', 'fa fa-globe', Regions::class),
            MenuItem::linkToUrl('Voir sur le site','fa fa-desktop', 'http://localhost:8000/regions'),

            MenuItem::section('User'),
            MenuItem::linkToCrud('User', 'fa fa-user', User::class),
            MenuItem::linkToUrl('Voir sur le site','fa fa-desktop', 'http://localhost:8000/user'),

            MenuItem::section('Déconnexion'),
            MenuItem::linkToUrl('Déconnexion','fa fa-sign-out', 'http://localhost:8000/logout'),
        ];

    }
}
