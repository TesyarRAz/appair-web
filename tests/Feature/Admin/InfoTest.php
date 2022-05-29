<?php

namespace Tests\Feature\Admin;

use App\Models\Info;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InfoTest extends TestCase
{
    public function test_index()
    {
        $this->admin()
            ->get('/admin/info')
            ->assertStatus(200);
    }

    public function test_store()
    {
        $data = Info::factory()->make()->toArray();

        $this->admin()
            ->post('/admin/info', $data)
            ->assertStatus(302)
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('infos', $data);
    }

    public function test_edit()
    {
        $info = Info::factory()->create();

        $data = Info::factory()->make()->toArray();

        $this->admin()
            ->put('/admin/info/' . $info->id, $data)
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('infos', $data);
    }

    public function test_delete()
    {
        $info = Info::factory()->create();

        $this->admin()
            ->delete('/admin/info/' . $info->id)
            ->assertStatus(302)
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('infos', [
            'id' => $info->id,
        ]);
    }
}
