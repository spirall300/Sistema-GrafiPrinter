<?php

namespace Tests\Feature;

use App\Models\ProductType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTypeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_duplicate_product_type_name_stays_on_index_with_error_message(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        ProductType::create(['name' => 'Tarjetas']);

        $response = $this->actingAs($admin)
            ->from(route('product-types.index'))
            ->post(route('product-types.store'), [
                'name' => 'tarjetas',
            ]);

        $response->assertRedirect(route('product-types.index'));
        $response->assertSessionHas('error', 'Ya existe un tipo de producto registrado con ese nombre.');
        $response->assertSessionHasInput('name');
    }
}
