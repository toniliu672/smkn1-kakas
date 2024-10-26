<!-- admin/pages/dashboard -->
<?php
require_once '../../auth/auth_check.php';
check_login();

$page_title = "Dashboard - SMKN 1 Kakas"; // Judul halaman dinamis
?>

<!DOCTYPE html>
<html lang="en">
<!-- Import CSS khusus hanya di halaman ini -->
<link rel="stylesheet" href="../css/styles.css">

<?php include '../components/head.php'; ?>

<body class="bg-gray-100">
    <?php include '../components/navbar.php'; ?>
    <div class="bg-image"></div>

    <div class="container mx-auto px-4 py-16">
        <!-- Hero Section -->
        <section class="text-center py-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg mb-12 glassmorphism">
            <h1 class="text-4xl font-bold mb-2">Selamat Datang, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
            <p class="text-lg mb-6">Role Anda: <span class="font-semibold"><?php echo htmlspecialchars($_SESSION['user_role']); ?></span></p>
        </section>

        <!-- Menu Utama -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="glassmorphism text-center">
                <i class="fas fa-users text-4xl text-purple-600 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Data Siswa</h3>
                <p class="text-gray-700 mb-4">Lihat dan kelola data siswa SMKN 1 Kakas.</p>
                <a href="./datasiswa.php" class="text-blue-600 font-semibold hover:text-blue-800">Lihat Data &rarr;</a>
            </div>

            <div class="glassmorphism text-center">
                <i class="fas fa-chalkboard-teacher text-4xl text-green-600 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Data Guru</h3>
                <p class="text-gray-700 mb-4">Akses informasi lengkap tentang guru-guru sekolah.</p>
                <a href="./dataguru.php" class="text-green-600 font-semibold hover:text-green-800">Lihat Data &rarr;</a>
            </div>

            <div class="glassmorphism text-center">
                <i class="fas fa-file-alt text-4xl text-yellow-600 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Manajemen Surat</h3>
                <p class="text-gray-700 mb-4">Kelola surat masuk dan surat keluar sekolah.</p>
                <a href="./surat_masuk.php" class="text-yellow-600 font-semibold hover:text-yellow-800 mr-4">Surat Masuk</a>
                <a href="./surat_keluar.php" class="text-yellow-600 font-semibold hover:text-yellow-800">Surat Keluar</a>
            </div>
        </section>

 <!-- Statistik Section -->
<section class="mb-12">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Statistik</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Jumlah Siswa -->
        <div class="stat-card group">
            <div class="stat-card-inner">
                <i class="fas fa-user-graduate text-4xl text-gray-500 mb-2"></i>
                <h3 class="text-2xl font-semibold">7,910</h3>
                <p>Jumlah Siswa</p>
            </div>
        </div>

        <!-- Jumlah Guru -->
        <div class="stat-card group">
            <div class="stat-card-inner">
                <i class="fas fa-chalkboard-teacher text-4xl text-gray-500 mb-2"></i>
                <h3 class="text-2xl font-semibold">305</h3>
                <p>Jumlah Guru</p>
            </div>
        </div>

        <!-- Jumlah Kelas -->
        <div class="stat-card group">
            <div class="stat-card-inner">
                <i class="fas fa-school text-4xl text-gray-500 mb-2"></i>
                <h3 class="text-2xl font-semibold">4,404</h3>
                <p>Jumlah Kelas</p>
            </div>
        </div>

        <!-- Program Studi -->
        <div class="stat-card group">
            <div class="stat-card-inner">
                <i class="fas fa-book text-4xl text-gray-500 mb-2"></i>
                <h3 class="text-2xl font-semibold">34</h3>
                <p>Program Studi</p>
            </div>
        </div>
    </div>
</section>



    </div>
</body>

</html>