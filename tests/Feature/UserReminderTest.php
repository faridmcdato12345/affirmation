<?php

namespace Tests\Feature;

use App\Http\Traits\ConvertTimeZone;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

class UserReminderTest extends TestCase
{
    use ConvertTimeZone;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_on_first_attempt_of_updating_the_user_reminder()
    {
        $this->withExceptionHandling();
        $this->get(route('setting.reminder.index'));
        $user = User::factory()->create();
        $clientOriginalTime = '09:00:00';
        $reminder = $user->reminders()->create(
            [
                'original_time' => $clientOriginalTime,
                'time' => $this->convertTimeZone('Asia/Manila', $clientOriginalTime),
                'timezone' => 'Asia/Manila'
            ]
        );
        $response = $this->followingRedirects()
                    ->patch('/settings/reminder/'.$reminder, [
                        'cutom_messages' => 'a update from phpunit test'
                    ])
                    ->assertInertia(
                        fn (AssertableInertia $page) => $page
                        ->component('Pages/Setting/Reminder')
                        ->where('errors',[])
                    );
        // $response->assertRedirectToRoute('setting.reminder.index');
    }
}
