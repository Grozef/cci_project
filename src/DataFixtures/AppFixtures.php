<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Book;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Awarded;
use App\Entity\UserInfo;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this ->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        //Users
        $users = [];
        for ($i = 0; $i < 49; $i++) { 
            $user = new User();
            $user->setName($this->faker->name())
                ->setPseudonym($this->faker->firstName())
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPassword('password');
            
            $users[] = $user;
            $manager->persist($user);
                }

        //Admin
        $admin = new User();
        $admin->setName('steve')
        ->setPseudonym('steve')
        ->setEmail('steve@gmail.com')
        ->setRoles(['ROLE_ADMIN'])
        ->setPassword('password');
        $manager->persist($admin);


        //Books
        $books = [];
        for ($i = 0; $i < 50; $i++) {
        $book = new Book();   
        $book ->setTitle ($this->faker->word())
                ->setAuthor ($this->faker->word())
                ->setDescription ($this->faker->word())
                ->setPrice(mt_rand(0, 30))
                ->setIdAwarded(mt_rand(1, 3));

                $books[] = $book;
                $manager->persist($book);
            };

        //UserInfo
        $infos = [];
        for ($j = 0; $j < 50; $j++) {
            $info =new UserInfo();
            $info->setDirection($this->faker->word())
                ->setPostalCode(mt_rand(00001, 97999))
                ->setTown($this->faker->word())
                ->setCountry('France')
                // rajouter le 0 devant le tel
                ->setTel(0 .(mt_rand(600000000, 799999999)))
                ->setIdUser(mt_rand(1, 50));
                
            $infos[] = $info;
            $manager->persist($info);
        }

        //Awarded
        $awards = [];
        for ($k = 0; $k < 3; $k++) {
            $award =new Awarded();
            $award->setName($this->faker->word());
            $awards[] = $award;
            $manager->persist($award);
        }

        // rajouter les fixtures pour awarded et category

            $manager->flush();
    }
}
