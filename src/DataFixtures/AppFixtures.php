<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\ThePlace;
use Faker\Factory;
use App\Entity\Book;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Awarded;
use App\Entity\UserInfo;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this ->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        //awarded

        $award = new Awarded();
        $award->setName('prix du jury');
        $manager->persist($award);
        $manager->flush($award);
        
                
                $award =new Awarded();
                $award->setName('Prix France Inter');
                $manager->persist($award);
                $manager->flush($award); 

        //category
        $category = new Category(); 
        $category->setName($this->faker->name());
        $manager->persist($category); 
        $manager->flush($category);                 
        
        //the_place
        $place = new ThePlace();
        $place->setNamePlace('Bibliothèque de Villeurbanne');
        $manager->persist($place);
        $manager->flush($place); 

        //Users
        $users = [];
        for ($i = 0; $i < 24; $i++) { 
            $user = new User();
            $user->setName($this->faker->name())
                ->setPseudonym($this->faker->firstName())
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');
       // géré par un event listener         
       // $hashPassword = $this->hasher->hashPassword($user, 'password');
       // $user->setPassword($hashPassword);
            $users[] = $user;
            $manager->persist($user);
            $manager->flush($users); 
                }
        $manager->flush($users);        

        //Admin
        $admin = new User();
        $admin->setName('steve')
        ->setPseudonym('steve')
        ->setEmail('steve@gmail.com')
        ->setRoles(['ROLE_ADMIN'])
        ->setPlainPassword('password');
        $manager->persist($admin);
        $manager->flush($admin); 

        //Category
        $category = new Category();
            $category->setName('Science Fiction');
            $manager->persist($category);
            $manager->flush($category);
            

        //Books
        $books = [];
        for ($i = 0; $i < 50; $i++) {
        $book = new Book();   
        $book ->setTitle ($this->faker->word())
                ->setAuthor ($this->faker->word())
                ->setDescription ($this->faker->word())
                ->setPrice(mt_rand(0, 30));

                $books[] = $book;
                $manager->persist($book);
                $manager->flush($book);
            };
/*
        //UserInfo
        $infos = [];

        for ($j = 0; $j = count($users); $j++) {
            $info =new UserInfo();
            $info->setDirection($this->faker->word())
                ->setPostalCode(mt_rand(00001, 97999))
                ->setTown($this->faker->word())
                ->setCountry('France')
                // rajouter le 0 devant le tel
                ->setTel(0 .(mt_rand(600000000, 799999999)));

            // rajouter le userId
                
            $infos[] = $info;
            $manager->persist($info);
            $manager->flush($info);
        }
*/        
    } 
}
