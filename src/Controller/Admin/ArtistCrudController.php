<?php

namespace App\Controller\Admin;

use App\Entity\Artist;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_EDITOR')]
class ArtistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Artist::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm(),
            TextField::new('name', "Nom de l'artiste/groupe"),
            TextareaField::new('biography',"Description")
                ->hideOnIndex(),
                TextField::new('imageFile')->setFormType(VichImageType::class)
                ->onlyOnForms(),
            ImageField::new('imageName', "Image")->setBasePath('/images/artist')->setUploadDir('/public/images/artiste')
                ->onlyOnIndex(),

        ];
    }
    
}
