<?php
// admin/pages/editSiswa.php
require_once '../../config/koneksi.php';
require_once '../../auth/auth_check.php';
require_once '../functions/siswa/read.php';
require_once '../functions/jurusan/read.php';
require_once '../functions/angkatan/read.php';
check_admin();

$page_title = "Edit Data Siswa - SMKN 1 Kakas";
$id = $_GET['id'] ?? '';

if (empty($id)) {
    header('Location: dataSiswa.php');
    exit;
}

// Ambil data siswa yang akan diedit
$result = getDetailSiswa($pdo, $id);
if (!$result || isset($result['status']) && $result['status'] === 'error') {
    header('Location: dataSiswa.php');
    exit;
}

$siswa = $result['data'];
$daftarJurusan = getAllJurusan($pdo);
$daftarAngkatan = getAllAngkatan($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../components/head.php'; ?>

<body class="bg-gray-100">
    <?php include '../components/navbar.php'; ?>

    <div class="container mx-auto px-4 py-10">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Data Siswa</h1>
                <a href="./dataSiswa.php" class="text-sky-500 hover:text-sky-600">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

            <form id="formEditSiswa" enctype="multipart/form-data">
                <input type="hidden" name="action" value="updateSiswa">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Data Utama -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NIS</label>
                            <input type="text" name="nis" value="<?php echo htmlspecialchars($siswa['nis'] ?? ''); ?>"
                                class="w-full px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NISN</label>
                            <input type="text" name="nisn" value="<?php echo htmlspecialchars($siswa['nisn'] ?? ''); ?>"
                                class="w-full px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap" required 
                                value="<?php echo htmlspecialchars($siswa['nama_lengkap']); ?>"
                                class="w-full px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Angkatan *</label>
                            <select name="id_angkatan" required 
                                class="w-full px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-sky-500">
                                <?php foreach ($daftarAngkatan as $angkatan): ?>
                                    <option value="<?php echo htmlspecialchars($angkatan['id']); ?>"
                                        <?php echo ($siswa['id_angkatan'] === $angkatan['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($angkatan['tahun']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jurusan *</label>
                            <select name="id_jurusan" required 
                                class="w-full px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-sky-500">
                                <?php foreach ($daftarJurusan as $jurusan): ?>
                                    <option value="<?php echo htmlspecialchars($jurusan['id']); ?>"
                                    <?php echo ($siswa['id_jurusan'] === $jurusan['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($jurusan['nama_jurusan']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Data Kontak -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($siswa['email'] ?? ''); ?>"
                                class="w-full px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">No. HP</label>
                            <input type="text" name="no_hp" value="<?php echo htmlspecialchars($siswa['no_hp'] ?? ''); ?>"
                                class="w-full px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                            <textarea name="alamat" rows="3" 
                                class="w-full px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-sky-500"><?php echo htmlspecialchars($siswa['alamat'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ayah</label>
                        <input type="text" name="nama_ayah" value="<?php echo htmlspecialchars($siswa['nama_ayah'] ?? ''); ?>"
                            class="w-full px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ibu</label>
                        <input type="text" name="nama_ibu" value="<?php echo htmlspecialchars($siswa['nama_ibu'] ?? ''); ?>"
                            class="w-full px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" value="<?php echo htmlspecialchars($siswa['pekerjaan_ayah'] ?? ''); ?>"
                            class="w-full px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" value="<?php echo htmlspecialchars($siswa['pekerjaan_ibu'] ?? ''); ?>"
                            class="w-full px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. HP Orang Tua</label>
                        <input type="text" name="no_hp_orang_tua" value="<?php echo htmlspecialchars($siswa['no_hp_orang_tua'] ?? ''); ?>"
                            class="w-full px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                </div>

                <!-- Foto -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Siswa</label>
                    <?php if (!empty($siswa['foto_siswa'])): ?>
                        <div class="mb-2">
                            <img src="../../<?php echo htmlspecialchars($siswa['foto_siswa']); ?>" 
                                alt="Foto Siswa" class="w-32 h-32 object-cover rounded">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="foto" accept="image/jpeg,image/jpg,image/png"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal 10MB.</p>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="dataSiswa.php" class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 bg-sky-500 text-white rounded hover:bg-sky-600">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#formEditSiswa').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: '../functions/siswa/',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (typeof response === 'string') {
                            response = JSON.parse(response);
                        }
                        
                        if (response.status === 'success') {
                            $.toast({
                                heading: 'Success',
                                text: response.message,
                                icon: 'success',
                                position: 'top-right',
                                hideAfter: 3000,
                                afterHidden: function() {
                                    window.location.href = 'dataSiswa.php';
                                }
                            });
                        } else {
                            $.toast({
                                heading: 'Error',
                                text: response.message,
                                icon: 'error',
                                position: 'top-right'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        $.toast({
                            heading: 'Error',
                            text: 'Terjadi kesalahan: ' + error,
                            icon: 'error',
                            position: 'top-right'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>