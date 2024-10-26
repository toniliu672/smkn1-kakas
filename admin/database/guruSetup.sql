-- admin/database/guruSetup.sql

-- Tabel guru 
CREATE TABLE IF NOT EXISTS guru (
    id VARCHAR(15) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    nomor_telepon VARCHAR(15),
    foto VARCHAR(255),
    tanggal_bergabung DATE NOT NULL,
    tanggal_nonaktif DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT chk_tanggal CHECK (tanggal_nonaktif IS NULL OR tanggal_nonaktif > tanggal_bergabung)
);

-- Tabel mata pelajaran (perlu updated_at untuk fitur refresh)
CREATE TABLE IF NOT EXISTS mata_pelajaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_mapel VARCHAR(100) NOT NULL,
    kode_mapel VARCHAR(10) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel relasi guru dan mata pelajaran (composite primary key)
CREATE TABLE IF NOT EXISTS guru_mata_pelajaran (
    guru_id VARCHAR(15),
    mapel_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (guru_id, mapel_id),
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE CASCADE,
    FOREIGN KEY (mapel_id) REFERENCES mata_pelajaran(id) ON DELETE CASCADE
);

-- Index untuk optimasi pencarian
CREATE INDEX idx_guru_nama ON guru(nama);
CREATE INDEX idx_guru_status ON guru(tanggal_nonaktif);
CREATE INDEX idx_mapel_nama ON mata_pelajaran(nama_mapel);

-- Trigger untuk generate ID unik guru
DELIMITER //
CREATE TRIGGER before_insert_guru
BEFORE INSERT ON guru
FOR EACH ROW
BEGIN
    IF NEW.id IS NULL OR NEW.id = '' THEN
        SET NEW.id = CONCAT(
            'TCH',
            DATE_FORMAT(NOW(), '%Y%m%d'),
            LPAD(FLOOR(RAND() * 10000), 4, '0')
        );
    END IF;
END//
DELIMITER ;