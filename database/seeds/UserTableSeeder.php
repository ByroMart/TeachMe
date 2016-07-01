<?php

use TeachMe\Entities\User;
use Faker\Factory as Faker;
use Faker\Generator;

class UserTableSeeder extends BaseSeeder {

    public function getModel()
    {
        return new User;
    }

    public function getDummyData(Generator $faker,array $customValues = array())
    {
        return [
            'name' => $faker->name,
            'email'=>$faker->email,
            'password'=>bcrypt('secret')
        ];
    }

    public function run()
    {
        $this->createAdmin();
        $this->createMultiple(50);
    }


    public function createAdmin()
    {
        $this->create([
            'name'      => 'Byron Martinez',
            'email'     => 'byronmartinez@gmail.com',
            'password'  => bcrypt(123456)
        ]);
    }

}