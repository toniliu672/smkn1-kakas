<?php
// admin/functions/siswa/update.php

function updateSiswa($pdo, $id, $data, $foto = null) {
    try {
        // Validasi NIS dan NISN jika diubah
        if (!empty($data['nis'])) {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM siswa WHERE nis = ? AND id != ?");
            $stmt->execute([$data['nis'], $id]);
            if ($stmt->fetchColumn() > 0) {
                throw new Exception("NIS sudah terdaftar!");
            }
        }

        if (!empty($data['nisn'])) {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM siswa WHERE nisn = ? AND id != ?");
            $stmt->execute([$data['nisn'], $id]);
            if ($stmt->fetchColumn() > 0) {
                throw new Exception("NISN sudah terdaftar!");
            }
        }

        // Handle upload foto baru jika ada
        $fotoPath = null;
        if ($foto && $foto['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            $maxSize = 10 * 1024 * 1024; // 10MB

            if (!in_array($foto['type'], $allowedTypes)) {
                throw new Exception("Tipe file tidak diizinkan. Hanya JPG, JPEG, dan PNG yang diperbolehkan.");
            }

            if ($foto['size'] > $maxSize) {
                throw new Exception("Ukuran file terlalu besar. Maksimal 10MB.");
            }

            // Hapus foto lama jika ada
            $stmt = $pdo->prepare("SELECT foto_siswa FROM siswa WHERE id = ?");
            $stmt->execute([$id]);
            $oldFoto = $stmt->fetchColumn();
            if ($oldFoto && file_exists("../../../" . $oldFoto)) {
                unlink("../../../" . $oldFoto);
            }

            $extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
            $fotoPath = 'uploads/siswa/' . $id . '.' . $extension;

            if (!move_uploaded_file($foto['tmp_name'], "../../../" . $fotoPath)) {
                throw new Exception("Gagal mengupload foto.");
            }
        }

        // Mulai transaksi
        $pdo->beginTransaction();

        // Validasi angkatan dan jurusan jika diubah
        if (isset($data['id_angkatan'])) {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM angkatan WHERE id = ?");
            $stmt->execute([$data['id_angkatan']]);
            if ($stmt->fetchColumn() == 0) {
                throw new Exception("Angkatan tidak valid!");
            }
        }

        if (isset($data['id_jurusan'])) {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM jurusan WHERE id = ?");
            $stmt->execute([$data['id_jurusan']]);
            if ($stmt->fetchColumn() == 0) {
                throw new Exception("Jurusan tidak valid!");
            }
        }

        // Build update query
        $setClause = [];
        $params = [];

        // Daftar field yang bisa diupdate
        $allowedFields = [
            'id_angkatan', 'id_jurusan', 'nis', 'nisn', 'nama_lengkap',
            'alamat', 'no_hp', 'email', 'nama_ayah', 'nama_ibu',
            'pekerjaan_ayah', 'pekerjaan_ibu', 'no_hp_orang_tua'
        ];

        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $setClause[] = "$field = ?";
                $params[] = $data[$field];
            }
        }

        if ($fotoPath) {
            $setClause[] = "foto_siswa = ?";
            $params[] = $fotoPath;
        }

        $params[] = $id; // untuk WHERE clause

        $query = "UPDATE siswa SET " . implode(", ", $setClause) . " WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);

        $pdo->commit();
        return [
            'status' => 'success', 
            'message' => 'Data siswa berhasil diperbarui'
        ];

    } catch (Exception $e) {
        $pdo->rollBack();
        // Hapus foto baru jika ada error
        if (isset($fotoPath) && file_exists("../../../" . $fotoPath)) {
            unlink("../../../" . $fotoPath);
        }
        return [
            'status' => 'error', 
            'message' => $e->getMessage()
        ];
    }
}