<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\MessageFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserFactory::new()->state([
            'name' => 'Support',
            'email' => 'support@prodmee.com',
            'password' => '123456',
        ])->createOne();

        $user = UserFactory::new()->state([
             'name' => 'Alex',
             'email' => 'test@test.com',
             'password' => '123456',
        ])->has(MessageFactory::new()->count(10), 'sendedMessages')
            ->createOne();

        foreach ($user->sendedMessages as $message) {
            MessageFactory::new()->state([
                 'from_id' => $message->to_id,
                 'to_id' => $user->id,
             ])->createMany(10);
        }
    }
}
