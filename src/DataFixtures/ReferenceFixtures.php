<?php

namespace App\DataFixtures;

use App\Entity\StatusMission;
use App\Entity\StatusApplication;
use App\Entity\InvoiceStatus;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReferenceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $missionStatuses = ['en attente de freelance', 'en cours', 'terminée', 'facturée', 'payée'];
        foreach ($missionStatuses as $label) {
            $status = new StatusMission();
            $status->setLabel($label);
            $manager->persist($status);
        }

        $applicationStatuses = ['en attente', 'acceptée', 'refusée'];
        foreach ($applicationStatuses as $label) {
            $status = new StatusApplication();
            $status->setLabel($label);
            $manager->persist($status);
        }

        $invoiceStatuses = ['en attente', 'validée', 'payée'];
        foreach ($invoiceStatuses as $label) {
            $status = new InvoiceStatus();
            $status->setLabel($label);
            $manager->persist($status);
        }

        $categories = ['Développement web', 'Design', 'Rédaction', 'Marketing', 'Traduction'];
        foreach ($categories as $label) {
            $category = new Category();
            $category->setLabel($label);
            $manager->persist($category);
        }

        $manager->flush();
    }
}