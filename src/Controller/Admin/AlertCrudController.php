<?php

namespace App\Controller\Admin;

use App\Entity\Alert;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_EDITOR')]
class AlertCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Alert::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Alertes')
            ->setEntityLabelInSingular('Alerte')
            ->setPageTitle("index","Nation-Sounds - Administration des alertes")
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm(),
            TextField::new('type',"Type d'alerte"),
            TextareaField::new('message',"Message"),
        ];
    }
}
