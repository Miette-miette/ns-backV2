<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Evènements')
            ->setEntityLabelInSingular('Evènement')
            ->setPageTitle("index","Nation-Sounds - Administration des évènements")
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm(),
            AssociationField::new('artist', "Nom de l'artiste/groupe"),
            ChoiceField::new('type', "Type d'évènement")->setChoices([
                'Concert' => 'concert',
                'Performance' => 'performance',
                'Atelier' => 'workshop'
            ]),
            AssociationField::new('location', "Scène"),
            DateField::new('date',"Jour de l'évènement"),
            TimeField::new('begin_time',"Heure de début"),
            TimeField::new('end_time',"Heure de fin"),
        ];
    }
}
