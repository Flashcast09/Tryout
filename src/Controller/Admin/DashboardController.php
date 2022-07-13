<?php

namespace App\Controller\Admin;


use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Controller\Admin\Product;
use App\Entity\Categories;
use App\Entity\Products;
use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
        
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
        ->setController(ProductsCrudController::class)
        ->generateUrl();

         return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ZYZZ PROJECT');
            
    }

    public function configureMenuItems(): iterable
    {   
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-arrow-left', 'main');
        yield MenuItem::section('Gérer les produits');
        

        yield MenuItem::subMenu('Products', 'fas fa-bars')->setSubItems([
            MenuItem::LinkToCrud('Add product', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW),
            MenuItem::LinkToCrud('Show product', 'fas fa-eye', Products::class)
      ]);

        yield MenuItem::subMenu('Categories', 'fas fa-bars')->setSubItems([
            MenuItem::LinkToCrud('Add categories', 'fas fa-plus', Categories::class)->setAction(Crud::PAGE_NEW),
            MenuItem::LinkToCrud('Show categories', 'fas fa-eye', Categories::class)
      ]);

        yield MenuItem::subMenu('Users', 'fas fa-user')->setSubItems([
            // MenuItem::LinkToCrud('Add users', 'fas fa-plus', Users::class)->setAction(Crud::PAGE_NEW),
            MenuItem::LinkToCrud('Show users', 'fas fa-eye', Users::class)
        ]);

        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
