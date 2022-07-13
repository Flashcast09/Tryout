<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class ProductsCrudController extends AbstractCrudController
{
    // public const ACTION_DUPLICATE = 'duplicate';

    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    // public function configureActions(Actions $actions): Actions
    // {

    //     $duplicate = Action::new(self::ACTION_DUPLICATE)
    //     ->linkToCrudAction('duplicateProduct')
    //     ->setCssClass('btn btn-info');
        

    //     return $actions
    //     ->add(Crud::PAGE_EDIT, $duplicate)
    //     ->reorder(Crud::PAGE_EDIT, [self::ACTION_DUPLICATE, Action::SAVE_AND_RETURN]);
    // }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            IntegerField::new('Stock'),
            MoneyField::new('price')->setCurrency('EUR'),
            ImageField::new('image')
            ->setBasePath('public/upload/images/products')
            ->setUploadDir('public/upload/images/products'),
            AssociationField::new('categories'),
            TextEditorField::new('description'),
            TextField::new('Slug'),
        ];
    }

    // public function duplicateProduct(AdminContext $context, AdminUrlGenerator $adminUrlGenerator, EntityManagerInterface $em): response
    // {
    //     /** @var Product $product */
    //     $product = $context->getEntity()->getInstance();

    //     $duplicatedproduct = clone $product;

    //     parent::persistEntity($em, $duplicatedProduct);

    //     $url = $adminUrlGenerator->setController(self::class)
    //     ->setAction(Action::DETAIL)
    //     ->setEntityId($duplicatedProduct->getId())
    //     ->generateUrl();

    //     return $this->redirect($url);
    // }
    
}
