<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Provider;

use Faker\Generator;
use Vigihdev\FakerReflection\Contracts\BioDtoInterface;
use Vigihdev\FakerReflection\DTOs\VehicleDto;
use Vigihdev\FakerReflection\DtoTransformer;
use Vigihdev\FakerReflection\Enums\ProviderResource;

final class PatternBasedStringProvider
{

    public static function build(Generator $faker): array
    {
        return array_merge(self::oneLevelPatterns($faker), self::twoLevelPattern($faker));
    }

    private static function bio(): BioDtoInterface
    {
        return DtoTransformer::fromProviderResource(ProviderResource::BIO);
    }

    private static function oneLevelPatterns(Generator $faker): array
    {
        $patterns = [
            // ── Lebih spesifik dulu ────────────────────────────────────────
            '/nik|ktp|nomor_ktp|no_ktp/'               => fn() => $faker->numerify('################'), // 16 digit
            '/npwp|nomor_npwp|no_npwp/'                => fn() => $faker->numerify('##.###.###.#-###.###'),
            '/nomor_rekening|no_rekening| rekening/'   => fn() => $faker->numerify('###############'), // 10-15 digit
            '/nama_rekening|pemilik_rekening/'         => fn() => $faker->name(),
            '/bank/'                                   => fn() => $faker->randomElement(['BCA', 'MANDIRI', 'BNI', 'BRI', 'BTN', 'CIMB', 'Permata', 'Maybank']),
            '/foto_ktp|selfie_ktp|ktp_image/'          => fn() => $faker->imageUrl(640, 480, 'people', true, 'ktp'),
            '/avatar|foto_profil|profile_picture/'     => fn() => $faker->imageUrl(200, 200, 'people', true),
            '/referral_code|kode_referral/'            => fn() => strtoupper($faker->bothify('???###??')),
            '/kode_pos|zipcode|postal/'                => fn() => $faker->postcode(),
            '/rt|rw/'                                  => fn() => 'RT ' . $faker->numberBetween(1, 15) . ' / RW ' . $faker->numberBetween(1, 10),

            // ── Email & credential ─────────────────────────────────────────
            '/email/'                                  => fn() => $faker->unique()->safeEmail(),
            '/password|kata_sandi|pass/'               => fn() => $faker->password(12, 20),

            // ── Nama (lebih spesifik dulu) ─────────────────────────────────
            '/nama_lengkap|full_name/'                 => fn() => $faker->name(),
            '/nama_depan|first_name/'                  => fn() => $faker->firstName(),
            '/nama_belakang|last_name/'                => fn() => $faker->lastName(),
            '/nama_panggilan|nickname/'                => fn() => $faker->firstName(),

            // ── Alamat lokal ───────────────────────────────────────────────
            '/alamat|address/'                         => fn() => $faker->streetAddress() . ', ' . $faker->city() . ' ' . $faker->postcode(),
            '/provinsi/'                               => fn() => $faker->randomElement(['Jawa Timur', 'Jawa Barat', 'DKI Jakarta', 'Jawa Tengah', 'Banten', 'DI Yogyakarta', 'Sumatera Utara']),
            '/kota|kabupaten|city/'                    => fn() => $faker->city(),
            '/kecamatan/'                              => fn() => $faker->citySuffix(), // approx
            '/kelurahan|desa/'                         => fn() => $faker->streetName(),

            // ── Tanggal & waktu ────────────────────────────────────────────
            '/created_at|updated_at|email_verified_at|phone_verified_at|last_login|tgl|tanggal/'
            => fn() => $faker->dateTimeBetween('-2 years')->format('Y-m-d H:i:s'),
            '/birthdate|tanggal_lahir|tgl_lahir/'      => fn() => $faker->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),

            // ── Boolean flags ──────────────────────────────────────────────
            '/is_|has_|verified|active|published/'     => fn() => $faker->boolean(80) ? 'true' : 'false', // 80% true

            // ── Status & enum umum ─────────────────────────────────────────
            '/status/'                                 => fn() => $faker->randomElement(['active', 'inactive', 'pending', 'banned', 'verified']),
            '/kyc_status|status_kyc/'                  => fn() => $faker->randomElement(['pending', 'verified', 'rejected']),
            '/role|hak_akses/'                         => fn() => $faker->randomElement(['admin', 'user', 'seller', 'buyer', 'moderator']),

            // ── Lain-lain yang sering muncul ───────────────────────────────
            '/slug/'                                   => fn() => $faker->slug(3),
            '/title|judul/'                            => fn() => $faker->sentence(4, true),
            '/meta_description|deskripsi/'             => fn() => $faker->paragraph(1),
            '/color|warna/'                            => fn() => $faker->hexColor(),
            '/point|saldo|balance/'                    => fn() => $faker->numberBetween(0, 500000),

            '/bio|tentang_saya|deskripsi_diri/' => fn() => $faker->randomElement(self::bio()->text()),
        ];

        return $patterns;
    }

    private static function twoLevelPattern(Generator $faker): array
    {
        /** @var VehicleDto $vehicle */
        $vehicle = DtoTransformer::fromProviderResource(ProviderResource::VEHICLE);
        return [
            '/namaMobil|nama_mobil|nama_kendaraan|merk_mobil|model/' => fn() => $faker->randomElement($vehicle->mobils()),
            '/paketSewa|paket_sewa|paket/' => fn() => $faker->randomElement($vehicle->paketSewas()),
        ];
    }
}
