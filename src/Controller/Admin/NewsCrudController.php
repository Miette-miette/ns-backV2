<?php

namespace App\Controller\Admin;

use App\Entity\News;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_EDITOR')]
class NewsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return News::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Actualités')
            ->setEntityLabelInSingular('Actualité')
            ->setPageTitle("index","Nation-Sounds - Administration des actualités du festival")
            ->setPaginatorPageSize(10);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm(),
            TextField::new('title',"Titre de l'article"),
            TextareaField::new('summary',"Chapeau")
                ->hideOnIndex(),
            TextareaField::new('content',"Contenu")
                ->hideOnIndex(),
            TextField::new('imageFile')->setFormType(VichImageType::class)
                ->onlyOnForms(),
            ImageField::new('imageName',"Image")->setBasePath('/images/ns_img_content')->setUploadDir('/public/images/ns_img_content')
                ->onlyOnIndex(),
        ];
    }
}
