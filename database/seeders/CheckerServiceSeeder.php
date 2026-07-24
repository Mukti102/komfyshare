<?php

namespace Database\Seeders;

use App\Models\CheckerQuestion;
use App\Models\CheckerQuestionOption;
use App\Models\CheckerService;
use App\Models\CheckerOrder;
use App\Models\CheckerFile;
use App\Models\CheckerAnswer;
use App\Models\CheckerPayment;
use App\Models\CheckerStatusLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CheckerServiceSeeder extends Seeder
{
    public function run(): void
    {   
           Schema::disableForeignKeyConstraints();

    // Child tables
    CheckerAnswer::truncate();
    CheckerFile::truncate();
    CheckerStatusLog::truncate();
    CheckerPayment::truncate(); // jika ada

    // Parent transaction
    CheckerOrder::truncate();

    // Master
    CheckerQuestionOption::truncate();
    CheckerQuestion::truncate();
    CheckerService::truncate();

    Schema::enableForeignKeyConstraints();

     // ===================================================================
// SERVICE 1 : CEK PLAGIARISME
// ===================================================================

$plagiarism = CheckerService::create([
    'name' => 'Cek Plagiarisme',
    'slug' => 'cek-plagiarisme',
    'icon' => 'heroicon-o-shield-check',
    'description' => 'Pengecekan plagiarisme menggunakan Turnitin.',
    'estimated_hours' => 6,
    'status' => true,
    'sort_order' => 1,
    'color' => '#8B5CF6',
]);

/*
|--------------------------------------------------------------------------
| Upload File
|--------------------------------------------------------------------------
*/

CheckerQuestion::create([
    'checker_service_id' => $plagiarism->id,
    'label' => 'Upload Dokumen',
    'field_name' => 'document',
    'field_type' => 'file',
    'is_required' => true,
    'sort_order' => 1,

    'affects_price' => true,
    'pricing_rule' => 'per_file',
    'unit_price' => 25000,
]);

/*
|--------------------------------------------------------------------------
| Judul
|--------------------------------------------------------------------------
*/

CheckerQuestion::create([
    'checker_service_id' => $plagiarism->id,
    'label' => 'Judul (Optional)',
    'field_name' => 'title',
    'field_type' => 'text',
    'placeholder' => 'Masukkan Judul',
    'is_required' => false,
    'sort_order' => 2,

    'affects_price' => false,
    'pricing_rule' => 'none',
]);

/*
|--------------------------------------------------------------------------
| Kode Promo
|--------------------------------------------------------------------------
*/

CheckerQuestion::create([
    'checker_service_id' => $plagiarism->id,
    'label' => 'Kode Promo',
    'field_name' => 'promo_code',
    'field_type' => 'text',
    'placeholder' => 'Kode Promo',
    'is_required' => false,
    'sort_order' => 3,

    'affects_price' => false,
    'pricing_rule' => 'none',
]);

/*
|--------------------------------------------------------------------------
| Kecualikan Daftar Pustaka
|--------------------------------------------------------------------------
*/

$q = CheckerQuestion::create([
    'checker_service_id' => $plagiarism->id,
    'label' => 'Kecualikan Daftar Pustaka',
    'field_name' => 'exclude_bibliography',
    'field_type' => 'checkbox',
    'is_required' => false,
    'sort_order' => 4,

    'affects_price' => true,
    'pricing_rule' => 'option',
]);

CheckerQuestionOption::create([
    'checker_question_id' => $q->id,
    'label' => 'Ya',
    'value' => '1',
    'additional_price' => 5000,
]);

/*
|--------------------------------------------------------------------------
| Kecualikan Kutipan
|--------------------------------------------------------------------------
*/

$q = CheckerQuestion::create([
    'checker_service_id' => $plagiarism->id,
    'label' => 'Kecualikan Kutipan',
    'field_name' => 'exclude_quotes',
    'field_type' => 'checkbox',
    'is_required' => false,
    'sort_order' => 5,

    'affects_price' => true,
    'pricing_rule' => 'option',
]);

CheckerQuestionOption::create([
    'checker_question_id' => $q->id,
    'label' => 'Ya',
    'value' => '1',
    'additional_price' => 5000,
]);

/*
|--------------------------------------------------------------------------
| Exclude Match
|--------------------------------------------------------------------------
*/

$q = CheckerQuestion::create([
    'checker_service_id' => $plagiarism->id,
    'label' => 'Exclude Match',
    'field_name' => 'exclude_match',
    'field_type' => 'checkbox',
    'is_required' => false,
    'sort_order' => 6,

    'affects_price' => true,
    'pricing_rule' => 'option',
]);

CheckerQuestionOption::create([
    'checker_question_id' => $q->id,
    'label' => 'Ya',
    'value' => '1',
    'additional_price' => 5000,
]);




// ===================================================================
// SERVICE 2 : CEK AI / DRILLBIT
// ===================================================================

$drillbit = CheckerService::create([
    'name' => 'Cek AI / Drillbit',
    'slug' => 'cek-ai-drillbit',
    'icon' => 'heroicon-o-cpu-chip',
    'description' => 'Deteksi konten AI menggunakan Drillbit.',
    'estimated_hours' => 6,
    'status' => true,
    'sort_order' => 2,
    'color' => '#6366F1',
]);

/*
|--------------------------------------------------------------------------
| Upload Dokumen
|--------------------------------------------------------------------------
*/

CheckerQuestion::create([
    'checker_service_id' => $drillbit->id,
    'label' => 'Upload Dokumen',
    'field_name' => 'document',
    'field_type' => 'file',
    'is_required' => true,
    'sort_order' => 1,

    'affects_price' => true,
    'pricing_rule' => 'per_file',
    'unit_price' => 30000,
]);

/*
|--------------------------------------------------------------------------
| Judul
|--------------------------------------------------------------------------
*/

CheckerQuestion::create([
    'checker_service_id' => $drillbit->id,
    'label' => 'Judul (Optional)',
    'field_name' => 'title',
    'field_type' => 'text',
    'placeholder' => 'Masukkan Judul',
    'is_required' => false,
    'sort_order' => 2,

    'affects_price' => false,
    'pricing_rule' => 'none',
]);

/*
|--------------------------------------------------------------------------
| Bahasa
|--------------------------------------------------------------------------
*/

$language = CheckerQuestion::create([
    'checker_service_id' => $drillbit->id,
    'label' => 'Bahasa',
    'field_name' => 'language',
    'field_type' => 'select',
    'is_required' => true,
    'sort_order' => 3,

    'affects_price' => false,
    'pricing_rule' => 'none',
]);

CheckerQuestionOption::create([
    'checker_question_id' => $language->id,
    'label' => 'Indonesia',
    'value' => 'id',
    'additional_price' => 0,
    'sort_order' => 1,
]);

CheckerQuestionOption::create([
    'checker_question_id' => $language->id,
    'label' => 'English',
    'value' => 'en',
    'additional_price' => 0,
    'sort_order' => 2,
]);

CheckerQuestionOption::create([
    'checker_question_id' => $language->id,
    'label' => 'Malaysia',
    'value' => 'my',
    'additional_price' => 0,
    'sort_order' => 3,
]);

/*
|--------------------------------------------------------------------------
| Kode Promo
|--------------------------------------------------------------------------
*/

CheckerQuestion::create([
    'checker_service_id' => $drillbit->id,
    'label' => 'Kode Promo',
    'field_name' => 'promo_code',
    'field_type' => 'text',
    'placeholder' => 'Kode Promo',
    'is_required' => false,
    'sort_order' => 4,

    'affects_price' => false,
    'pricing_rule' => 'none',
]);



// ===================================================================
// SERVICE 3 : PARAFRASE
// ===================================================================

$parafrase = CheckerService::create([
    'name' => 'Parafrase',
    'slug' => 'parafrase',
    'icon' => 'heroicon-o-document-text',
    'description' => 'Layanan parafrase manual oleh tim Mulfu.',
    'estimated_hours' => 24,
    'status' => true,
    'sort_order' => 3,
    'color' => '#F59E0B',
]);

/*
|--------------------------------------------------------------------------
| Upload File Original
|--------------------------------------------------------------------------
*/

CheckerQuestion::create([
    'checker_service_id' => $parafrase->id,
    'label' => 'File Original',
    'field_name' => 'original_file',
    'field_type' => 'file',
    'is_required' => true,
    'sort_order' => 1,

    'affects_price' => false,
    'pricing_rule' => 'none',
]);

/*
|--------------------------------------------------------------------------
| Upload Hasil Turnitin
|--------------------------------------------------------------------------
*/

CheckerQuestion::create([
    'checker_service_id' => $parafrase->id,
    'label' => 'Hasil Turnitin',
    'field_name' => 'turnitin_file',
    'field_type' => 'file',
    'is_required' => true,
    'sort_order' => 2,

    'affects_price' => false,
    'pricing_rule' => 'none',
]);

/*
|--------------------------------------------------------------------------
| Paket Pengerjaan
|--------------------------------------------------------------------------
*/

$package = CheckerQuestion::create([
    'checker_service_id' => $parafrase->id,
    'label' => 'Pilih Paket',
    'field_name' => 'package',
    'field_type' => 'select',
    'is_required' => true,
    'sort_order' => 3,

    'affects_price' => true,
    'pricing_rule' => 'option',
]);

CheckerQuestionOption::create([
    'checker_question_id' => $package->id,
    'label' => 'Reguler (3-5 Hari)',
    'value' => 'regular',
    'additional_price' => 50000,
    'sort_order' => 1,
]);

CheckerQuestionOption::create([
    'checker_question_id' => $package->id,
    'label' => 'Express 24 Jam',
    'value' => 'express24',
    'additional_price' => 80000,
    'sort_order' => 2,
]);

CheckerQuestionOption::create([
    'checker_question_id' => $package->id,
    'label' => 'Express 12 Jam',
    'value' => 'express12',
    'additional_price' => 100000,
    'sort_order' => 3,
]);

/*
|--------------------------------------------------------------------------
| Target Similarity
|--------------------------------------------------------------------------
*/

$targetSim = CheckerQuestion::create([
    'checker_service_id' => $parafrase->id,
    'label' => 'Turunkan Persentase ke',
    'field_name' => 'target_similarity',
    'field_type' => 'select',
    'is_required' => true,
    'sort_order' => 4,

    'help_text' => 'Pilih rentang target similarity (%)',

    'affects_price' => true,
    'pricing_rule' => 'option',
]);

CheckerQuestionOption::create([
    'checker_question_id' => $targetSim->id,
    'label' => 'Di bawah 10%',
    'value' => 'under_10',
    'additional_price' => 100000,
]);

CheckerQuestionOption::create([
    'checker_question_id' => $targetSim->id,
    'label' => '11% - 20%',
    'value' => '11_to_20',
    'additional_price' => 50000,
]);

CheckerQuestionOption::create([
    'checker_question_id' => $targetSim->id,
    'label' => 'Di atas 20%',
    'value' => 'above_20',
    'additional_price' => 0,
]);

/*
|--------------------------------------------------------------------------
| Bahasa
|--------------------------------------------------------------------------
*/

$language = CheckerQuestion::create([
    'checker_service_id' => $parafrase->id,
    'label' => 'Bahasa',
    'field_name' => 'language',
    'field_type' => 'select',
    'is_required' => true,
    'sort_order' => 5,

    'affects_price' => false,
    'pricing_rule' => 'none',
]);

CheckerQuestionOption::create([
    'checker_question_id' => $language->id,
    'label' => 'Bahasa Indonesia',
    'value' => 'id',
    'additional_price' => 0,
]);

CheckerQuestionOption::create([
    'checker_question_id' => $language->id,
    'label' => 'English',
    'value' => 'en',
    'additional_price' => 0,
]);

/*
|--------------------------------------------------------------------------
| Note
|--------------------------------------------------------------------------
*/

CheckerQuestion::create([
    'checker_service_id' => $parafrase->id,
    'label' => 'Note',
    'field_name' => 'note',
    'field_type' => 'textarea',
    'placeholder' => 'Catatan tambahan...',
    'is_required' => false,
    'sort_order' => 6,

    'affects_price' => false,
    'pricing_rule' => 'none',
]);




// ===================================================================
// SERVICE 4 : Perbaikan Dokumen
// ===================================================================

$service = CheckerService::create([
    'name' => 'Perbaikan Dokumen',
    'slug' => 'perbaikan-dokumen',
    'icon' => 'heroicon-o-document-check',
    'description' => 'Layanan perbaikan format dan penyusunan dokumen skripsi, tesis maupun jurnal.',
    'estimated_hours' => 24,
    'is_token_available' => false,
    'status' => true,
    'sort_order' => 4,
    'color' => '#8B5CF6',
]);

// Upload Dokumen
CheckerQuestion::create([
    'checker_service_id' => $service->id,
    'label' => 'Upload Dokumen',
    'field_name' => 'upload_dokumen',
    'field_type' => 'file',
    'is_required' => true,
    'sort_order' => 1,
    'help_text' => 'Upload file yang akan diperbaiki.',
    'affects_price' => false,
    'pricing_rule' => 'none',
]);

// Penomoran Halaman
$q = CheckerQuestion::create([
    'checker_service_id' => $service->id,
    'label' => 'Penomoran Halaman',
    'field_name' => 'penomoran_halaman',
    'field_type' => 'checkbox',
    'is_required' => false,
    'sort_order' => 2,
    'affects_price' => true,
    'pricing_rule' => 'option',
]);

CheckerQuestionOption::create([
    'checker_question_id' => $q->id,
    'label' => 'Perbaiki Penomoran Halaman',
    'value' => 'yes',
    'additional_price' => 5000,
]);

// Daftar Isi Otomatis
$q = CheckerQuestion::create([
    'checker_service_id' => $service->id,
    'label' => 'Daftar Isi Otomatis',
    'field_name' => 'daftar_isi',
    'field_type' => 'checkbox',
    'is_required' => false,
    'sort_order' => 3,
    'affects_price' => true,
    'pricing_rule' => 'option',
]);

CheckerQuestionOption::create([
    'checker_question_id' => $q->id,
    'label' => 'Buat Daftar Isi Otomatis',
    'value' => 'yes',
    'additional_price' => 10000,
]);

// Daftar Gambar
$q = CheckerQuestion::create([
    'checker_service_id' => $service->id,
    'label' => 'Daftar Gambar',
    'field_name' => 'daftar_gambar',
    'field_type' => 'checkbox',
    'is_required' => false,
    'sort_order' => 4,
    'affects_price' => true,
    'pricing_rule' => 'option',
]);

CheckerQuestionOption::create([
    'checker_question_id' => $q->id,
    'label' => 'Buat Daftar Gambar',
    'value' => 'yes',
    'additional_price' => 5000,
]);

// Daftar Tabel
$q = CheckerQuestion::create([
    'checker_service_id' => $service->id,
    'label' => 'Daftar Tabel',
    'field_name' => 'daftar_tabel',
    'field_type' => 'checkbox',
    'is_required' => false,
    'sort_order' => 5,
    'affects_price' => true,
    'pricing_rule' => 'option',
]);

CheckerQuestionOption::create([
    'checker_question_id' => $q->id,
    'label' => 'Buat Daftar Tabel',
    'value' => 'yes',
    'additional_price' => 5000,
]);

// Daftar Lampiran
$q = CheckerQuestion::create([
    'checker_service_id' => $service->id,
    'label' => 'Daftar Lampiran',
    'field_name' => 'daftar_lampiran',
    'field_type' => 'checkbox',
    'is_required' => false,
    'sort_order' => 6,
    'affects_price' => true,
    'pricing_rule' => 'option',
]);

CheckerQuestionOption::create([
    'checker_question_id' => $q->id,
    'label' => 'Buat Daftar Lampiran',
    'value' => 'yes',
    'additional_price' => 5000,
]);

// Header & Footer
$q = CheckerQuestion::create([
    'checker_service_id' => $service->id,
    'label' => 'Header & Footer',
    'field_name' => 'header_footer',
    'field_type' => 'checkbox',
    'is_required' => false,
    'sort_order' => 7,
    'affects_price' => true,
    'pricing_rule' => 'option',
]);

CheckerQuestionOption::create([
    'checker_question_id' => $q->id,
    'label' => 'Perbaiki Header & Footer',
    'value' => 'yes',
    'additional_price' => 5000,
]);

// Margin
$q = CheckerQuestion::create([
    'checker_service_id' => $service->id,
    'label' => 'Margin Dokumen',
    'field_name' => 'margin',
    'field_type' => 'checkbox',
    'is_required' => false,
    'sort_order' => 8,
    'affects_price' => true,
    'pricing_rule' => 'option',
]);

CheckerQuestionOption::create([
    'checker_question_id' => $q->id,
    'label' => 'Sesuaikan Margin',
    'value' => 'yes',
    'additional_price' => 5000,
]);

// Format Sitasi
$q = CheckerQuestion::create([
    'checker_service_id' => $service->id,
    'label' => 'Perbaikan Sitasi',
    'field_name' => 'sitasi',
    'field_type' => 'checkbox',
    'is_required' => false,
    'sort_order' => 9,
    'affects_price' => true,
    'pricing_rule' => 'option',
]);

CheckerQuestionOption::create([
    'checker_question_id' => $q->id,
    'label' => 'Perbaiki Format Sitasi',
    'value' => 'yes',
    'additional_price' => 10000,
]);

// Daftar Pustaka
$q = CheckerQuestion::create([
    'checker_service_id' => $service->id,
    'label' => 'Daftar Pustaka',
    'field_name' => 'daftar_pustaka',
    'field_type' => 'checkbox',
    'is_required' => false,
    'sort_order' => 10,
    'affects_price' => true,
    'pricing_rule' => 'option',
]);

CheckerQuestionOption::create([
    'checker_question_id' => $q->id,
    'label' => 'Perbaiki Daftar Pustaka',
    'value' => 'yes',
    'additional_price' => 10000,
]);

// Catatan Tambahan
CheckerQuestion::create([
    'checker_service_id' => $service->id,
    'label' => 'Catatan Tambahan',
    'field_name' => 'catatan',
    'field_type' => 'textarea',
    'is_required' => false,
    'sort_order' => 11,
    'affects_price' => false,
    'pricing_rule' => 'none',
]);

    }


}