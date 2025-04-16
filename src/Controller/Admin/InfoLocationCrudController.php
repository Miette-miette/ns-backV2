<?php

namespace App\Controller\Admin;

use App\Entity\InfoLocation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_EDITOR')]
class InfoLocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InfoLocation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Lieux')
            ->setEntityLabelInSingular('Lieu')
            ->setPageTitle("index","Nation-Sounds - Administration des lieux")
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm(),
            AssociationField::new('name',"Nom du lieu"),
            TimeField::new('opening',"Heure de début"),
            TimeField::new('closing',"Heure de fin"),
            TextareaField::new('description',"Description")
                ->hideOnIndex(),
                TextField::new('imageFile')->setFormType(VichImageType::class)
                ->onlyOnForms(),
            ImageField::new('imageName', "Image")->setBasePath('/images/location')->setUploadDir('/public/images/location')
                ->onlyOnIndex(),
        ];
    }
}
