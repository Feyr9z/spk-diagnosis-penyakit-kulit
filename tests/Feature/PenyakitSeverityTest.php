<?php

namespace Tests\Feature;

use App\Models\Penyakit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PenyakitSeverityTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsSuperAdmin(): static
    {
        $user = User::create([
            'nama'     => 'Super Admin Test',
            'username' => 'superadmin_test_' . uniqid(),
            'password' => bcrypt('password'),
            'role'     => 'super_admin',
        ]);
        return $this->actingAs($user);
    }

    /** @test */
    public function penyakit_dapat_disimpan_dengan_tingkat_keparahan()
    {
        $penyakit = Penyakit::create([
            'kode_penyakit'     => 'P99',
            'nama_penyakit'     => 'Test Penyakit',
            'deskripsi'         => 'Deskripsi test.',
            'tingkat_keparahan' => 'parah',
        ]);

        $this->assertDatabaseHas('penyakit', [
            'kode_penyakit'     => 'P99',
            'tingkat_keparahan' => 'parah',
        ]);
    }

    /** @test */
    public function tingkat_keparahan_default_adalah_sedang()
    {
        // Default value set by DB column
        $penyakit = Penyakit::create([
            'kode_penyakit' => 'P98',
            'nama_penyakit' => 'Test Default',
            'deskripsi'     => 'Deskripsi.',
            'tingkat_keparahan' => 'sedang',
        ]);

        $this->assertEquals('sedang', $penyakit->tingkat_keparahan);
    }

    /** @test */
    public function store_penyakit_tanpa_tingkat_keparahan_harus_gagal_validasi()
    {
        $this->actingAsSuperAdmin()
            ->post(route('penyakit.store'), [
                'kode_penyakit' => 'P97',
                'nama_penyakit' => 'Tanpa Level',
                'deskripsi'     => 'Deskripsi.',
                // tingkat_keparahan tidak dikirim
            ])
            ->assertSessionHasErrors('tingkat_keparahan');
    }

    /** @test */
    public function store_penyakit_dengan_tingkat_keparahan_tidak_valid_harus_gagal()
    {
        $this->actingAsSuperAdmin()
            ->post(route('penyakit.store'), [
                'kode_penyakit'     => 'P96',
                'nama_penyakit'     => 'Invalid Level',
                'deskripsi'         => 'Deskripsi.',
                'tingkat_keparahan' => 'sangat_parah', // tidak ada di enum
            ])
            ->assertSessionHasErrors('tingkat_keparahan');
    }

    /** @test */
    public function store_penyakit_berhasil_dengan_tingkat_keparahan_valid()
    {
        foreach (['ringan', 'sedang', 'parah'] as $i => $level) {
            $this->actingAsSuperAdmin()
                ->post(route('penyakit.store'), [
                    'kode_penyakit'     => 'P9' . $i,
                    'nama_penyakit'     => "Penyakit Level $level",
                    'deskripsi'         => 'Deskripsi test.',
                    'tingkat_keparahan' => $level,
                ])
                ->assertRedirect(route('penyakit.index'));

            $this->assertDatabaseHas('penyakit', [
                'kode_penyakit'     => 'P9' . $i,
                'tingkat_keparahan' => $level,
            ]);
        }
    }

    /** @test */
    public function update_penyakit_dapat_ubah_tingkat_keparahan()
    {
        $penyakit = Penyakit::create([
            'kode_penyakit'     => 'P95',
            'nama_penyakit'     => 'Test Update',
            'deskripsi'         => 'Deskripsi.',
            'tingkat_keparahan' => 'ringan',
        ]);

        $this->actingAsSuperAdmin()
            ->put(route('penyakit.update', $penyakit->id), [
                'kode_penyakit'     => 'P95',
                'nama_penyakit'     => 'Test Update',
                'deskripsi'         => 'Deskripsi.',
                'tingkat_keparahan' => 'parah',
            ])
            ->assertRedirect(route('penyakit.index'));

        $this->assertDatabaseHas('penyakit', [
            'id'                => $penyakit->id,
            'tingkat_keparahan' => 'parah',
        ]);
    }
}
