PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE doctrine_migration_versions (version VARCHAR(191) NOT NULL, executed_at DATETIME DEFAULT NULL, execution_time INTEGER DEFAULT NULL, PRIMARY KEY(version));
INSERT INTO doctrine_migration_versions VALUES('DoctrineMigrations\Version20240603184737','2024-06-03 18:50:30',255);
INSERT INTO doctrine_migration_versions VALUES('DoctrineMigrations\Version20240605190217','2024-06-05 19:05:08',4);
INSERT INTO doctrine_migration_versions VALUES('DoctrineMigrations\Version20240606190913','2024-06-06 19:09:27',4);
CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value INTEGER NOT NULL);
INSERT INTO product VALUES(2,'Keyboard_num_8',1337);
INSERT INTO product VALUES(3,'Keyboard_num_7',234);
INSERT INTO product VALUES(4,'Keyboard_num_5',493);
INSERT INTO product VALUES(5,'Keyboard_num_8',993);
INSERT INTO product VALUES(6,'Keyboard_num_7',328);
CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        );
CREATE TABLE library (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, isbn VARCHAR(13) NOT NULL, author VARCHAR(255) NOT NULL, cover VARCHAR(255) NOT NULL);
INSERT INTO library VALUES(1,'Fashonista','ISBN1','Author1','img/cover1.jpg');
INSERT INTO library VALUES(2,'My guide to sleep','ISBN2','Author2','img/cover2.jpg');
INSERT INTO library VALUES(3,'Get rich or die trying','ISBN3','Author3','img/cover3.jpg');
INSERT INTO library VALUES(4,'Flowers','ISBN4','Author1','https://images.unsplash.com/photo-1717764873047-aed4cb59c7e2?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
INSERT INTO library VALUES(5,'t5','isbn5','a5','c5');
INSERT INTO library VALUES(6,'6','6','6','6');
DELETE FROM sqlite_sequence;
INSERT INTO sqlite_sequence VALUES('product',6);
INSERT INTO sqlite_sequence VALUES('library',10);
CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name);
CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at);
CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at);
CREATE UNIQUE INDEX UNIQ_A18098BCCC1CF4E6 ON library (isbn);
COMMIT;
