CREATE DATABASE IF NOT EXISTS inventaris_db;
USE inventaris_db;

-- Tabel Kategori
CREATE TABLE kategori (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_kategori VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Supplier
CREATE TABLE supplier (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_supplier VARCHAR(100) NOT NULL,
    kontak VARCHAR(50),
    email VARCHAR(100),
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Produk
CREATE TABLE produk (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_produk VARCHAR(150) NOT NULL,
    kategori_id INT,
    supplier_id INT,
    harga DECIMAL(12,2) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE SET NULL,
    FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE SET NULL
);

-- Tabel Log Aktivitas (Bonus)
CREATE TABLE log_aktivitas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    aksi VARCHAR(50) NOT NULL,
    tabel VARCHAR(50) NOT NULL,
    record_id INT,
    deskripsi TEXT,
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed Data Kategori
INSERT INTO kategori (nama_kategori, deskripsi) VALUES
('Gitar', 'Gitar akustik, elektrik, dan bass'),
('Drum & Perkusi', 'Drum set, cymbal, dan perkusi lainnya'),
('Keyboard & Piano', 'Keyboard digital, piano, dan synthesizer'),
('Alat Tiup', 'Saxophone, trumpet, flute, dan clarinet'),
('Aksesoris', 'Pick, strap, cable, dan aksesoris lainnya'),
('Amplifier', 'Amp gitar, bass, dan PA system'),
('Recording', 'Mikrofon, audio interface, dan studio gear');

-- Seed Data Supplier
INSERT INTO supplier (nama_supplier, kontak, email, alamat) VALUES
('PT Musik Jaya', '081234567890', 'info@musikjaya.com', 'Jl. Sudirman No. 10, Jakarta'),
('Toko Harmoni', '082345678901', 'sales@harmoni.id', 'Jl. Gatot Subroto No. 5, Bandung'),
('Guitar Center ID', '083456789012', 'contact@guitarcenter.id', 'Jl. Thamrin No. 15, Jakarta'),
('Drum World', '084567890123', 'info@drumworld.com', 'Jl. Asia Afrika No. 20, Bandung'),
('Keyboard Store', '085678901234', 'sales@keyboardstore.id', 'Jl. Pemuda No. 8, Surabaya'),
('Wind Instruments Co', '086789012345', 'info@windinst.com', 'Jl. Diponegoro No. 12, Yogyakarta');

-- Seed Data Produk
INSERT INTO produk (nama_produk, kategori_id, supplier_id, harga, stok, deskripsi) VALUES
('Yamaha F310 Acoustic Guitar', 1, 1, 2500000.00, 15, 'Gitar akustik pemula berkualitas'),
('Fender Player Stratocaster', 1, 3, 12000000.00, 8, 'Gitar elektrik profesional'),
('Pearl Export Drum Set', 2, 4, 15000000.00, 5, 'Drum set lengkap 5 piece'),
('Roland FP-30X Digital Piano', 3, 5, 9500000.00, 10, 'Piano digital 88 keys weighted'),
('Yamaha YAS-280 Saxophone', 4, 6, 18000000.00, 3, 'Alto saxophone untuk pemula'),
('Shure SM58 Microphone', 7, 2, 2200000.00, 20, 'Mikrofon vocal standar industri'),
('Marshall DSL40CR Amplifier', 6, 1, 8500000.00, 7, 'Amp gitar 40 watt tube'),
('Ernie Ball Regular Slinky', 5, 3, 95000.00, 100, 'Senar gitar elektrik'),
('Korg Minilogue XD Synthesizer', 3, 5, 7800000.00, 6, 'Synthesizer analog 4 voice'),
('Zildjian A Custom Cymbal Set', 2, 4, 6500000.00, 12, 'Set cymbal profesional');