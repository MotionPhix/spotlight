<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateSampleUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-sample-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create sample users for testing admin dashboard';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Creating sample users...');

        $users = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+265991234567',
                'password' => 'password123',
                'registration_status' => 'pending',
                'amount_paid' => 0,
                'interests' => ['web development', 'mobile apps'],
                'location' => 'Lilongwe',
                'current_knowledge' => ['HTML', 'CSS'],
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '+265991234568',
                'password' => 'password123',
                'registration_status' => 'payment_pending',
                'amount_paid' => 0,
                'interests' => ['data science', 'AI'],
                'location' => 'Blantyre',
                'current_knowledge' => ['Python', 'SQL'],
            ],
            [
                'first_name' => 'Mike',
                'last_name' => 'Johnson',
                'email' => 'mike.johnson@example.com',
                'phone' => '+265991234569',
                'password' => 'password123',
                'registration_status' => 'completed',
                'amount_paid' => 7000.00,
                'payment_reference' => 'TXN001',
                'registered_at' => now(),
                'interests' => ['backend development'],
                'location' => 'Mzuzu',
                'current_knowledge' => ['PHP', 'Laravel'],
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Williams',
                'email' => 'sarah.williams@example.com',
                'phone' => '+265991234570',
                'password' => 'password123',
                'registration_status' => 'completed',
                'amount_paid' => 7000.00,
                'payment_reference' => 'TXN002',
                'registered_at' => now()->subDays(2),
                'interests' => ['frontend development', 'design'],
                'location' => 'Zomba',
                'current_knowledge' => ['JavaScript', 'React'],
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Brown',
                'email' => 'david.brown@example.com',
                'phone' => '+265991234571',
                'password' => 'password123',
                'registration_status' => 'completed',
                'amount_paid' => 7000.00,
                'payment_reference' => 'TXN003',
                'registered_at' => now()->subDays(5),
                'interests' => ['full stack development'],
                'location' => 'Kasungu',
                'current_knowledge' => ['Vue.js', 'Node.js'],
            ],
        ];

        foreach ($users as $userData) {
            if (!User::where('email', $userData['email'])->exists()) {
                $user = User::create($userData);
                $this->info("Created user: {$user->fullName()} ({$user->email})");
            } else {
                $this->warn("User already exists: {$userData['email']}");
            }
        }

        $this->info('Sample users creation completed!');
        $this->newLine();
        $this->info('Statistics:');
        $this->table(
            ['Status', 'Count'],
            [
                ['Total Users', User::count()],
                ['Pending', User::where('registration_status', 'pending')->count()],
                ['Payment Pending', User::where('registration_status', 'payment_pending')->count()],
                ['Completed', User::where('registration_status', 'completed')->count()],
                ['Total Revenue', 'MWK ' . number_format(User::where('registration_status', 'completed')->sum('amount_paid'), 2)],
            ]
        );
    }
}
