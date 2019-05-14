<?php

namespace App\DataFixtures;

use App\Entity\ProductCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    public const MENU_REFERENCE = 'menu';
    public const BURGER_REFERENCE = 'burger';
    public const BOISSON_REFERENCE = 'boisson';
    public const SNACK_REFERENCE = 'snack';
    public const SALADE_REFERENCE = 'salade';
    public const DESSERT_REFERENCE = 'dessert';

    public function load(ObjectManager $manager)
    {
        $categoriesName = ['Menus', 'Burgers', 'Boissons', 'Snacks', 'Salades', 'Desserts'];

        $categories = [];

        foreach($categoriesName as $name)
        {
            $category = new ProductCategory();
            $category->setName($name);

            $manager->persist($category);

            $categories[] = $category;
        }
        
        $this->addReference(self::MENU_REFERENCE, $categories[0]);
        $this->addReference(self::BURGER_REFERENCE, $categories[1]);
        $this->addReference(self::BOISSON_REFERENCE, $categories[2]);
        $this->addReference(self::SNACK_REFERENCE, $categories[3]);
        $this->addReference(self::SALADE_REFERENCE, $categories[4]);
        $this->addReference(self::DESSERT_REFERENCE, $categories[5]);


        $manager->flush();
    }
}
