CREATE TABLE IF NOT EXISTS categories_backup LIKE categories;
CREATE TABLE IF NOT EXISTS products_backup LIKE products;
CREATE TABLE IF NOT EXISTS stocks_backup LIKE stocks;
CREATE TABLE IF NOT EXISTS availabilities_backup LIKE availabilities;

INSERT INTO categories_backup SELECT * FROM categories;
INSERT INTO products_backup SELECT * FROM products;
INSERT INTO stocks_backup SELECT * FROM stocks;
INSERT INTO availabilities_backup SELECT * FROM availabilities; 