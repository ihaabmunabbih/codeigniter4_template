create table mst_modul
(
   id INT NOT NULL AUTO_INCREMENT,
   nama_modul VARCHAR(50) NOT NULL,
   url_modul VARCHAR(50) NOT NULL,
   id_parent INT NULL,
   order_modul INT NOT NULL,
   aksi_modul VARCHAR(255) NULL,
   status INT NULL DEFAULT 1,
   created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   created_by VARCHAR(50) NOT NULL,
   updated_at timestamp NULL,
   updated_by VARCHAR(50) NULL,
   PRIMARY KEY ( id )
);

INSERT INTO `modul` (`nama_modul`, `url_modul`, `order_modul`, `aksi_modul`, `created_by`) VALUES ('Pengaturan', '#', 99, 'view', 'ihaab');
INSERT INTO `modul` (`nama_modul`, `id_parent`, `url_modul`, `order_modul`, `aksi_modul`, `created_by`) VALUES ('Menu Management', 1, 'managementmodul', 1,  'view|add|edit|delete', 'ihaab');
INSERT INTO `modul` (`nama_modul`, `id_parent`, `url_modul`, `order_modul`, `aksi_modul`, `created_by`) VALUES ('Hak Akses Modul', 1, 'privilege', 2, 'view|add|edit|delete', 'ihaab');

create table mst_modul_aksi
(
   id INT NOT NULL AUTO_INCREMENT,
   nama_aksi VARCHAR(50) NOT NULL,
   deskripsi VARCHAR(255) NOT NULL,
   status INT NULL DEFAULT 1,
   created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   created_by VARCHAR(50) NOT NULL,
   updated_at timestamp NULL,
   updated_by VARCHAR(50) NULL,
   PRIMARY KEY ( id )
);

INSERT INTO `mst_modul_aksi`(`nama_aksi`, `deskripsi`, `created_by`) VALUES ('view','View','administrator');
INSERT INTO `mst_modul_aksi`(`nama_aksi`, `deskripsi`, `created_by`) VALUES ('add','Add','administrator');
INSERT INTO `mst_modul_aksi`(`nama_aksi`, `deskripsi`, `created_by`) VALUES ('edit','Edit','administrator');
INSERT INTO `mst_modul_aksi`(`nama_aksi`, `deskripsi`, `created_by`) VALUES ('delete','Delete','administrator');
INSERT INTO `mst_modul_aksi`(`nama_aksi`, `deskripsi`, `created_by`) VALUES ('print_pdf','Print PDF','administrator');
INSERT INTO `mst_modul_aksi`(`nama_aksi`, `deskripsi`, `created_by`) VALUES ('print_excel','Print Excel','administrator');
INSERT INTO `mst_modul_aksi`(`nama_aksi`, `deskripsi`, `created_by`) VALUES ('approve','Approve','administrator');
INSERT INTO `mst_modul_aksi`(`nama_aksi`, `deskripsi`, `created_by`) VALUES ('upload_excel','upload_excel','administrator');

create table mst_modul_privileges
(
   id INT NOT NULL AUTO_INCREMENT,
   id_modul INT NOT NULL,
   id_group INT NOT NULL,
   nama_aksi VARCHAR(50) NOT NULL,
   status_aksi INT NULL DEFAULT 1,
   PRIMARY KEY ( id )
);

INSERT INTO `mst_modul_privileges` (`id_modul`, `id_group`, `nama_aksi`, `status_aksi`) VALUES ('3','1','view','1');
INSERT INTO `mst_modul_privileges` (`id_modul`, `id_group`, `nama_aksi`, `status_aksi`) VALUES ('3','1','add','1');
INSERT INTO `mst_modul_privileges` (`id_modul`, `id_group`, `nama_aksi`, `status_aksi`) VALUES ('3','1','edit','1');

create table mst_user
(
   id INT NOT NULL AUTO_INCREMENT,
   username VARCHAR(50) NOT NULL,
   password VARCHAR(255) NOT NULL,
   nama VARCHAR(255) NOT NULL,
   email VARCHAR(100) NULL,
   nomor_telepon VARCHAR(100) NULL,
   user_group VARCHAR(100) NOT NULL,
   status INT NULL DEFAULT 1,
   created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   created_by VARCHAR(50) NOT NULL,
   updated_at timestamp NULL,
   updated_by VARCHAR(50) NULL,
   PRIMARY KEY ( id )
);

create table mst_user_group
(
   id INT NOT NULL AUTO_INCREMENT,
   user_group VARCHAR(50) NOT NULL,
   group_name VARCHAR(255) NOT NULL,
   deskripsi VARCHAR(255) NOT NULL,
   status INT NULL DEFAULT 1,
   created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   created_by VARCHAR(50) NOT NULL,
   updated_at timestamp NULL,
   updated_by VARCHAR(50) NULL,
   PRIMARY KEY ( id )
);