<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Product;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $menusName = ['Menu Classic', 'Menu Bacon', 'Menu Big', 'Menu Chiken', 'Menu Fish', 'Menu Double Steak'];
        $menusDescription = [
            'Sandwich: Burger, Salade, Tomate, Cornichon + Frites + Boisson',
            'Sandwich: Burger, Fromage, Bacon, Salade, Tomate + Frites + Boisson',
            'Sandwich: Double Burger, Fromage, Cornichon, Salade + Frites + Boisson',
            'Sandwich: Poulet Frit, Tomate, Salade, Mayonnaise + Frites + Boisson',
            'Sandwich: Poisson, Salade, Mayonnaise, Cornichon + Frites + Boisson',
            'Sandwich: Double Burger, Fromage, Bacon, Salade, Tomate + Frites + Boisson'
        ];
        $menusPrice = [8.9, 9.5, 10.9, 9.9, 10.9, 11.9];
        
        for($i = 0; $i < 6; $i++)
        {
            $product = new Product();
            $product->setName($menusName[$i]);
            $product->setDescription($menusDescription[$i]);
            $product->setPrice($menusPrice[$i]);
            $product->setCategory($this->getReference(CategoryFixtures::MENU_REFERENCE));
            $fileNumber = $i+1;
            $product->setFilename('m' . $fileNumber . '.png');
            $product->setUpdatedAt(new \DateTime());

            $manager->persist($product);
        }


        $burgersName = ['Classic', 'Bacon', 'Big', 'Chiken', 'Fish', 'Double Steak'];
        $burgersDescription = [
            'Sandwich: Burger, Salade, Tomate, Cornichon',
            'Sandwich: Burger, Fromage, Bacon, Salade, Tomate',
            'Sandwich: Double Burger, Fromage, Cornichon, Salade',
            'Sandwich: Poulet Frit, Tomate, Salade, Mayonnaise',
            'Sandwich: Poisson, Salade, Mayonnaise, Cornichon',
            'Sandwich: Double Burger, Fromage, Bacon, Salade, Tomate'
        ];
        $burgersPrice = [5.9, 6.5, 6.9, 5.9, 6.5, 7.5];
        
        for($i = 0; $i  < 6; $i++)
        {
            $product = new Product();
            $product->setName($burgersName[$i]);
            $product->setDescription($burgersDescription[$i]);
            $product->setPrice($burgersPrice[$i]);
            $product->setCategory($this->getReference(CategoryFixtures::BURGER_REFERENCE));
            $fileNumber = $i+1;
            $product->setFilename('b' . $fileNumber . '.png');
            $product->setUpdatedAt(new \DateTime());

            $manager->persist($product);
        }


        $snacksName = ['Frites', 'Onion Rings', 'Nuggets', 'Nuggets Fromage', 'Ailes de Poulet'];
        $snacksDescription = [
            'Pommes de terre frites',
            'Rondelles d\'oignon frits',
            'Nuggets de poulet frits',
            'Nuggets de fromage frits',
            'Ailes de poulet Barbecue'
        ];
        $snacksPrice = [3.9, 3.4, 5.9, 3.5, 5.9];
        
        for($i = 0; $i  < 5; $i++)
        {
            $product = new Product();
            $product->setName($snacksName[$i]);
            $product->setDescription($snacksDescription[$i]);
            $product->setPrice($snacksPrice[$i]);
            $product->setCategory($this->getReference(CategoryFixtures::SNACK_REFERENCE));
            $fileNumber = $i+1;
            $product->setFilename('s' . $fileNumber . '.png');
            $product->setUpdatedAt(new \DateTime());

            $manager->persist($product);
        }


        $saladesName = ['César Poulet Pané', 'César Poulet Grillé', 'Salade Light', 'Poulet Pané', 'Poulet Grillé'];
        $saladesDescription = [
            'Poulet Pané, Salade, Tomate et la fameuse sauce César',
            'Poulet Grillé, Salade, Tomate et la fameuse sauce César',
            'Salade, Tomate, Concombre, Maïs et Vinaigre balsamique',
            'Poulet Pané, Salade, Tomate et la sauce de votre choix',
            'Poulet Grillé, Salade, Tomate et la sauce de votre choix'
        ];
        $saladesPrice = [8.9, 8.9, 5.9, 7.9, 7.9];
        
        for($i = 0; $i  < 5; $i++)
        {
            $product = new Product();
            $product->setName($saladesName[$i]);
            $product->setDescription($saladesDescription[$i]);
            $product->setPrice($saladesPrice[$i]);
            $product->setCategory($this->getReference(CategoryFixtures::SALADE_REFERENCE));
            $fileNumber = $i+1;
            $product->setFilename('sa' . $fileNumber . '.png');
            $product->setUpdatedAt(new \DateTime());

            $manager->persist($product);
        }
        

        $boissonsName = ['Coca-Cola', 'Coca-Cola Light', 'Coca-Cola Zéro', 'Fanta', 'Sprite', 'Nestea'];
        $boissonsDescription = 'Au choix: Petit, Moyen ou Grand';
        $boissonsPrice = 1.9;
        
        for($i = 0; $i  < 6; $i++)
        {
            $product = new Product();
            $product->setName($boissonsName[$i]);
            $product->setDescription($boissonsDescription);
            $product->setPrice($boissonsPrice);
            $product->setCategory($this->getReference(CategoryFixtures::BOISSON_REFERENCE));
            $fileNumber = $i+1;
            $product->setFilename('bo' . $fileNumber . '.png');
            $product->setUpdatedAt(new \DateTime());

            $manager->persist($product);
        }


        $dessertsName = ['Fondant au chocolat', 'Muffin', 'Beignet', 'Milkshake', 'Sundae'];
        $dessertsDescription = [
            'Au choix: Chocolat Blanc ou au lait',
            'Au choix: Au fruits ou au chocolat',
            'Au choix: Au chocolat ou Ã  la vanille',
            'Au choix: Fraise, Vanille ou Chocolat',
            'Au choix: Fraise, Caramel ou Chocolat'
        ];
        $dessertsPrice = [8.9, 8.9, 5.9, 7.9, 7.9];
        
        for($i = 0; $i  < 5; $i++)
        {
            $product = new Product();
            $product->setName($dessertsName[$i]);
            $product->setDescription($dessertsDescription[$i]);
            $product->setPrice($dessertsPrice[$i]);
            $product->setCategory($this->getReference(CategoryFixtures::DESSERT_REFERENCE));
            $fileNumber = $i+1;
            $product->setFilename('d' . $fileNumber . '.png');
            $product->setUpdatedAt(new \DateTime());

            $manager->persist($product);
        }

        $manager->flush();
    }
}