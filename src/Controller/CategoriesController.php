<?php

namespace App\Controller;


use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories', name: 'categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'index')]
    
    public function index(CategoriesRepository $categoriesRepository): Response
    {

        return $this->render('categories/index.html.twig',[
            'controller name' => 'CategoriesController', 
            'categories' => $categoriesRepository->findBy([], ['categoryOrder' => 'ASC'])
        ]);
    }
   

    #[Route('/{slug}', name: 'list')]
    public function list(Categories $category): Response
    {   
        // On va chercher la liste des produits de la catégorie
        $products = $category->getProducts();
        
        return $this->render('categories/list.html.twig', compact('category', 'products' ) );
        
    }

}
