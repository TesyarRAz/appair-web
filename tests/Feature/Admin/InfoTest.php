<?php

namespace Tests\Feature\Admin;

use App\Models\Info;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InfoTest extends TestCase
{
    use WithFaker;

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

        Storage::fake('public');

        $data['image'] = UploadedFile::fake()->image('image.png');
        $data['_method'] = 'PUT';

        $this->admin()
            ->post('/admin/info/' . $info->id, $data, [
                'enctype' => 'multipart/form-data',
            ])
            ->assertSessionHasNoErrors();

        Storage::disk('public')->assertExists('images/info/' . $data['image']->hashName());

        unset($data['image']);
        unset($data['_method']);

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
