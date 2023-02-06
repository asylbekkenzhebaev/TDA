<?php

namespace Tests\Feature;

use App\Models\Popup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PopupControllerTest extends TestCase
{

    protected $user;
    protected $popup;


    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->popup = Popup::factory()->create();
    }

    /**
     * for all
     * @return void
     */
    public function testIndex()
    {
        $popup = $this->popup;

        $this->get(route('popups.index'))
            ->assertOk()
            ->assertSee($popup->name);
    }

    /**
     * for all
     * @return void
     */
    public function testShowPage()
    {
        $popup = $this->popup;
        $response = $this->get(route('popups.show', $popup));
        $response->assertOk();
    }


    /**
     * for an authorized user
     * @return void
     */
    public function testCreateFormForAuthUser()
    {
        $user = $this->user;
        $this->actingAs($user);

        $response = $this->get(route('popups.create'));
        $response->assertOK()
            ->assertSeeText('Create a new popup');
    }

    /**
     * for an authorized user
     * @return void
     */
    public function testStoreForAuthUser()
    {
        $user = $this->user;
        $this->actingAs($user);

        $popupData = [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
        ];
        $response = $this->post(route('popups.store'), $popupData);
        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('popups', $popupData);
    }


    /**
     * for an authorized user
     * @return void
     */
    public function testEditFormForAuthUser()
    {
        $user = $this->user;
        $this->actingAs($user);
        $popup = $this->popup;
        $response = $this->get(route('popups.edit', $popup));
        $response->assertOk()
            ->assertSeeText('Edit a popup');
    }

    /**
     * for an authorized user
     * @return void
     */
    public function testUpdateForAuthUser()
    {
        $user = $this->user;
        $this->actingAs($user);
        $popup = $this->popup;

        $popupData = [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
        ];

        $response = $this->put(
            route('popups.update', ['popup' => $popup]),
            $popupData
        );

        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('popups', array_merge($popupData, ['id' => $popup->id]));
    }

    /**
     * for an authorized user
     * @return void
     */
    public function testDestroyForAuthUser()
    {
        $user = $this->user;
        $this->actingAs($user);
        $popup = $this->popup;

        $this->delete(route('popups.destroy', $popup))
            ->assertRedirect()
            ->assertSessionDoesntHaveErrors();
        $this->assertDatabaseMissing('popups', ['id' => $popup->id]);
    }

    /**
     * for a guest
     * @return void
     */
    public function testCreateForGuest()
    {
        $response = $this->get(route('popups.create'));
        $response->assertRedirect('/login');
    }

    /**
     * for a guest
     * @return void
     */
    public function testStoreForGuest()
    {
        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
        ];
        $response = $this->post(route('popups.store'), $data);
        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('popups', $data);
    }


    /**
     * for a guest
     * @return void
     */
    public function testEditFormForGuest()
    {
        $popup = $this->popup;
        $response = $this->get(route('popups.edit', $popup));
        $response->assertRedirect('/login');
        $this->assertDatabaseHas('popups', ['id' => $popup->id]);

    }

    /**
     * for a guest
     * @return void
     */
    public function testUpdateForGuest()
    {
        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
        ];
        $popup = $this->popup;
        $response = $this->put(route('popups.update', $popup), $data);
        $response->assertRedirect('/login');
        $this->assertDatabaseHas('popups', ['id' => $popup->id]);
    }

    /**
     * for a guest
     * @return void
     */
    public function testDestroyForGuest()
    {
        $popup = $this->popup;
        $response = $this->delete(route('popups.destroy', $popup));
        $response->assertRedirect('/login');
        $this->assertDatabaseHas('popups', ['id' => $popup->id]);
    }
}
