<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate realistic Malaysian IC number (No. KP)
        // Format: YYMMDD + 2-digit state code + 4-digit serial
        $year = $this->faker->numberBetween(70, 99); // 1970-1999
        $month = str_pad($this->faker->numberBetween(1, 12), 2, '0', STR_PAD_LEFT);
        $day = str_pad($this->faker->numberBetween(1, 28), 2, '0', STR_PAD_LEFT);
        $stateCode = str_pad($this->faker->numberBetween(1, 16), 2, '0', STR_PAD_LEFT); // 01-16 valid Malaysian state codes
        $serial = str_pad($this->faker->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT);
        $no_kp = $year . $month . $day . $stateCode . $serial;

        // Malaysian names (mix of common Malay names)
        $malayFirstNames = ['Ahmad', 'Ali', 'Hassan', 'Ismail', 'Zainab', 'Fatimah', 'Siti', 'Nurul', 'Muhammad', 'Abdul', 'Nur', 'Amir', 'Farah', 'Aisyah'];
        $malayLastNames = ['Abdullah', 'Rahman', 'Ibrahim', 'Ahmad', 'Hassan', 'Mahmud', 'Yusof', 'Ismail', 'Sulaiman', 'Omar'];
        $nama = $this->faker->randomElement($malayFirstNames) . ' ' . $this->faker->randomElement($malayLastNames) . ' bin/binti ' . $this->faker->randomElement($malayLastNames);

        // Government email format
        $emailPrefix = strtolower(str_replace(' ', '.', $this->faker->firstName())) . $this->faker->numberBetween(100, 999);

        // Government grades
        $grades = ['N17', 'N22', 'N26', 'N29', 'N32', 'N36', 'N41', 'N44', 'N48', 'N52', 'N54', 'DG41', 'DG44', 'DG48', 'M', 'C'];

        return [
            'no_kp' => $no_kp,
            'no_pekerja' => 'KEP' . $this->faker->unique()->numberBetween(100000, 999999),
            'nama' => $nama,
            'emel' => $emailPrefix . '@kedah.gov.my',
            'no_telefon' => '01' . $this->faker->numberBetween(0, 9) . $this->faker->numerify('########'),
            'kata_laluan_hash' => static::$password ??= Hash::make('password'),
            'jabatan_id' => null, // Should be set via relationship
            'jawatan' => $this->faker->randomElement(['Pegawai Tadbir', 'Penolong Pegawai Tadbir', 'Pembantu Tadbir', 'Jurutera', 'Akauntan', 'Pegawai Perubatan']),
            'gred' => $this->faker->randomElement($grades),
            'peranan' => 'peserta', // Default role display
            'status_aktif' => true,
            'epsm_verified' => $this->faker->boolean(70), // 70% verified
            'epsm_last_synced_at' => $this->faker->boolean(70) ? $this->faker->dateTimeBetween('-30 days', 'now') : null,
            'epsm_raw_data' => null, // Can be set separately if needed
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
