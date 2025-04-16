<?php

namespace App\Controller\Admin;

use App\Entity\Map;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_EDITOR')]
class MapCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Map::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Cartes')
            ->setEntityLabelInSingular('Carte')
            ->setPageTitle("index","Nation-Sounds - Administration de la carte")
            ->setPaginatorPageSize(1);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm(),
            NumberField::new('lat',"Latitude"),
            NumberField::new('lng',"Longitude"),
        ];
    }
}
