<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_EDITOR')]
class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Demandes de contact')
            ->setEntityLabelInSingular('Demande de contact')
            ->setPageTitle("index","Nation-Sounds - Administration des demandes de contact")
            ->setPaginatorPageSize(10);
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm(),
            TextField::new('fullName',"Nom complet")
                ->setFormTypeOption('disabled','disabled'),
            TextField::new('pseudo', "Pseudo")
                ->setFormTypeOption('disabled','disabled'),
            TextField::new('email',"E-mail")
                ->setFormTypeOption('disabled','disabled'),
            TextareaField::new('message',"Message")
                ->setFormTypeOption('disabled','disabled')
                ->hideOnIndex(),
            DateTimeField::new('createdAt')
                ->hideOnForm(),
        ]; 
    }
}
