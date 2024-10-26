<?php
// admin/pages/printGuru.php
require_once '../../config/koneksi.php';
require_once '../../auth/auth_check.php';
require_once '../functions/guru/read.php';
check_login();

// Get all guru data without pagination
$result = getAllGuruForPrint($pdo);
$guru_data = $result['data'] ?? [];

// Get current date for the report
$current_date = date('d F Y');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru - SMK NEGERI 1 KAKAS</title>
    <link href="../../public/css/tailwind.css" rel="stylesheet">
    <style>
        @media print {
            @page {
                size: landscape;
                margin: 1cm;
            }
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .no-print {
                display: none !important;
            }
            .page-break {
                page-break-after: always;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #000;
                padding: 8px;
                font-size: 12px;
            }
            th {
                background-color: #f3f4f6 !important;
            }
        }
        .print-only {
            display: none;
        }
        @media print {
            .print-only {
                display: block;
            }
        }
    </style>
</head>

<body class="bg-white p-6">
    <!-- Print Button -->
    <div class="no-print mb-6 flex justify-between items-center">
        <a href="./dataGuru.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Kembali
        </a>
        <button onclick="window.print()" class="bg-sky-500 text-white px-4 py-2 rounded hover:bg-sky-600">
            Cetak Data
        </button>
    </div>

    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold mb-2">SMK NEGERI 1 KAKAS</h1>
        <h2 class="text-xl font-semibold mb-4">DAFTAR GURU</h2>
        <p class="text-sm">Tanggal Cetak: <?php echo $current_date; ?></p>
    </div>

    <!-- Table -->
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">No</th>
                <th class="border border-gray-300 px-4 py-2">NIP</th>
                <th class="border border-gray-300 px-4 py-2">Nama Lengkap</th>
                <th class="border border-gray-300 px-4 py-2">Status</th>
                <th class="border border-gray-300 px-4 py-2">Mata Pelajaran</th>
                <th class="border border-gray-300 px-4 py-2">Email</th>
                <th class="border border-gray-300 px-4 py-2">Kontak</th>
                <th class="border border-gray-300 px-4 py-2">Tanggal Bergabung</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($guru_data as $index => $guru): ?>
            <tr>
                <td class="border border-gray-300 px-4 py-2 text-center"><?php echo $index + 1; ?></td>
                <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($guru['nip'] ?? '-'); ?></td>
                <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($guru['nama_lengkap']); ?></td>
                <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($guru['status']); ?></td>
                <td class="border border-gray-300 px-4 py-2">
                    <?php 
                    if (!empty($guru['mata_pelajaran'])) {
                        echo implode(', ', array_map(function($mapel) {
                            return htmlspecialchars($mapel['nama']);
                        }, $guru['mata_pelajaran']));
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
                <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($guru['email'] ?? '-'); ?></td>
                <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($guru['kontak'] ?? '-'); ?></td>
                <td class="border border-gray-300 px-4 py-2">
                    <?php echo date('d/m/Y', strtotime($guru['tanggal_bergabung'])); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Footer -->
    <div class="mt-8 text-sm print-only">
        <div class="float-right mr-12">
            <p class="mb-16">Kakas, <?php echo $current_date; ?></p>
            <p>Kepala Sekolah</p>
        </div>
        <div class="clear-both"></div>
    </div>
</body>
</html>

<?php