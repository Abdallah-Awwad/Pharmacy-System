-- Creating Database 
CREATE DATABASE pharmacy
COLLATE utf8_unicode_ci;
USE pharmacy;

-- Members Table Creation 
CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(11) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE COLLATE utf8_bin,
	password VARCHAR(255) NOT NULL COLLATE utf8_bin,
    role VARCHAR(50),
	created_at DATETIME DEFAULT current_timestamp(),
	updated_at DATETIME DEFAULT current_timestamp()
);

-- Employee Table Creation 
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(11) NOT NULL,
    gender ENUM ('Male','Female','Other') NOT NULL DEFAULT 'Male',
    age INT(3),
    address VARCHAR(255),
    salary DECIMAL(10,2) NOT NULL
);

-- Customers Table Creation
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL UNIQUE,
    gender ENUM ('Male', 'Female') NOT NULL DEFAULT 'Male',
    phone VARCHAR(50) NOT NULL UNIQUE,
    address VARCHAR (150)
);

-- Manufacturers Table Creation 
CREATE TABLE manufacturers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    address VARCHAR(255),
    phone VARCHAR(50) NOT NULL
);

-- Medicines Table Creation 
CREATE TABLE medicines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    manufacture_id INT,
	FOREIGN KEY (manufacture_id) REFERENCES manufacturers(id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- Inventory Table Creation 
CREATE TABLE inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    med_id INT NOT NULL,
    purchase_price DECIMAL(10,2) NOT NULL,
    selling_price DECIMAL(10,2) NOT NULL,
    expiration_date DATE NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (med_id) REFERENCES medicines(id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- Expenses Table Creation 
CREATE TABLE expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description  VARCHAR(255),
    amount DECIMAL(10, 2) NOT NULL,
	category VARCHAR(255)
);

-- invoice Table Creation
CREATE TABLE invoice (
    id INT AUTO_INCREMENT PRIMARY KEY,
    issued_date DATETIME DEFAULT current_timestamp() NOT NULL,
    cus_id int NOT NULL,
    emp_id int NOT NULL,
    bill_type ENUM ('Sale', 'Return'),
    FOREIGN KEY (cus_id) REFERENCES customers(id) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (emp_id) REFERENCES employees(id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- invoice_details Table Creation 
CREATE TABLE invoice_details (
    invoice_id INT NOT NULL, 
    inventory_id INT NOT NULL,
    quantity INT NOT NULL,
    UNIQUE KEY `unique_id` (`invoice_id`,`inventory_id`),
    FOREIGN KEY (invoice_id) REFERENCES invoice(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (inventory_id) REFERENCES inventory(id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- =========================================================================================================== -- 
-- VIEWS --

-- all_invoices View Creation 
CREATE OR REPLACE VIEW all_invoices AS

SELECT 
	invoice.id,
    invoice.bill_type,
    invoice_details.inventory_id,
    invoice_details.quantity,
    inventory.selling_price AS price,
    inventory.selling_price * invoice_details.quantity AS total

FROM
	invoice
    
INNER JOIN invoice_details
	ON invoice.id = invoice_details.invoice_id
INNER JOIN inventory
	ON invoice_details.inventory_id = inventory.id

ORDER BY invoice.id;

-- sale_invoices View Creation 
CREATE OR REPLACE VIEW sale_invoices AS
SELECT 
    *
FROM 
    all_invoices
WHERE 
    bill_type = 'Sale';

-- return_invoices View Creation
CREATE OR REPLACE VIEW return_invoices AS
SELECT 
    *
FROM
    all_invoices
WHERE 
    bill_type = 'Return';

-- sales_invoices_total View Creation 
CREATE OR REPLACE VIEW sales_invoices_total AS
SELECT 
    id, 
    bill_type,
    SUM(quantity) AS items,
    SUM(total) AS total
FROM all_invoices
WHERE bill_type = 'Sale'
GROUP BY id;

-- all_invoices_total View Creation 
CREATE OR REPLACE VIEW all_invoices_total AS
SELECT 
    all_invoices.id,
    invoice.issued_date AS date,
    all_invoices.bill_type as type,
    SUM(all_invoices.quantity) AS items,
    SUM(all_invoices.total) AS total
FROM all_invoices
LEFT JOIN invoice ON  all_invoices.id = invoice.id
GROUP BY id;


-- return_invoices_total View Creation
CREATE OR REPLACE VIEW return_invoices_total AS
SELECT 
    id, 
    bill_type,
    SUM(quantity) AS items,
    SUM(total) AS total
FROM all_invoices
WHERE bill_type = 'Return'
GROUP BY id;

-- purchases
CREATE OR REPLACE VIEW purchases AS
Select 
    i.id AS inv_id,
    i.med_id AS id,
    medicines.name,
    i.purchase_price,
    i.selling_price,
    i.expiration_date,
    SUM(i.quantity) AS quantity

FROM inventory i

LEFT JOIN medicines ON i.med_id = medicines.id

GROUP BY i.med_id, i.purchase_price, i.selling_price, i.expiration_date

ORDER BY i.med_id, i.id;


-- stock
CREATE OR REPLACE VIEW stock AS
SELECT 

    purchases.* ,
    -- SUM(sale_invoices.quantity)  AS sold
    IFNULL(sale_invoices.quantity, 0)  AS sold,
    IFNULL(return_invoices.quantity, 0) AS returned,
    purchases.quantity - IFNULL(sale_invoices.quantity, 0) + IFNULL(return_invoices.quantity, 0) AS stock

FROM purchases

LEFT JOIN sale_invoices ON purchases.id = sale_invoices.inventory_id

LEFT JOIN return_invoices  ON purchases.id = return_invoices.inventory_id

LEFT JOIN medicines  ON purchases.id = medicines.id

GROUP BY purchases.id, purchases.purchase_price, purchases.selling_price, purchases.expiration_date

ORDER BY purchases.id;

/* 
Earning profit:
    sale_invoices - return_invoices - expenses - Salaries
*/

CREATE OR REPLACE VIEW earning AS 
select 
	(SELECT SUM(stock.Sold * stock.selling_price) FROM stock) AS sales,
	(SELECT SUM(stock.Returned * stock.selling_price) FROM stock) AS returned,
    (SELECT SUM(amount) FROM expenses) AS expenses,
    (SELECT SUM(salary) FROM employees) AS salaries,
    
    (SELECT SUM(stock.Sold * stock.selling_price) FROM stock) - 
    (SELECT SUM(stock.Returned * stock.selling_price) FROM stock) - 
    (SELECT SUM(amount) FROM expenses) - 
    (SELECT SUM(salary) FROM employees) AS net_earning;


-- =========================================================================================================== -- 

-- Inserting Data into the DB Tables
INSERT INTO `customers` (`id`, `name`, `gender`, `address`, `phone`)
VALUES 
    (1, 'Cash customer', 'Male', '', ''),
    (NULL, 'Customer1', 'Male', '', '2123123'),
    (NULL, 'Customer2', 'Female', '', '0123'),
    (NULL, 'Customer3', 'Male', '', '5233'),
    (NULL, 'Customer4', 'Male', '', '54645646'),
    (NULL, 'Customer5', 'Male', '', '8718923987'),
    (NULL, 'Customer6', 'Female', '', '123123'),
    (NULL, 'Customer7', 'Male', '', '123123123'),
    (NULL, 'Customer8', 'Male', '', '45654654645'),
    (NULL, 'Customer9', 'Female', '', '1546'),
    (NULL, 'Customer10', 'Male', '', '7897894563456'),
    (NULL, 'Customer11', 'Male', '', '123123123123'),
    (NULL, 'Customer12', 'Male', '', '45645645'),
    (NULL, 'Customer13', 'Female', '', '78546564456'),
    (NULL, 'Customer14', 'Female', '', '548978912'),
    (NULL, 'Customer15', 'Female', '', '7845564569'),
    (NULL, 'Customer16', 'Male', '', '544546'),
    (NULL, 'Customer17', 'Female', '', '123658879');


INSERT INTO `employees` (`id`, `name`, `phone`, `gender`, `age`, `address`, `salary`)
VALUES
    (NULL, 'Employee1', '01235123', 'Male', '', '', '20'),
    (NULL, 'Employee2', '546456', 'Male', '19', '', '15'),
    (NULL, 'Employee3', '456', 'Male', '32', '', '10'),
    (NULL, 'Employee4', '0123123', 'Female', '22', '', '12'),
    (NULL, 'Employee5', '423145', 'Male', '26', '', '30'),
    (NULL, 'Employee6', '1236', 'Female', '', '', '40');


INSERT INTO `invoice` (`id`, `issued_date`, `cus_id`, `emp_id`, `bill_type`)
VALUES 
    (NULL, '2023-05-23 14:28:13', '1', '3', 'Sale'),
    (NULL, '2023-05-23 14:29:08', '1', '3', 'Sale'),
    (NULL, '2023-05-24 05:14:06', '2', '6', 'Sale'),
    (NULL, '2023-05-24 08:28:13', '2', '6', 'Sale'),
    (NULL, '2023-05-24 14:28:13', '2', '6', 'Sale'),
    (NULL, '2023-05-25 00:28:13', '5', '1', 'Sale'),
    (NULL, '2023-05-26 01:18:30', '3', '2', 'Return'),
    (NULL, '2023-05-27 20:45:44', '2', '4', 'Return'),
    (NULL, '2023-05-27 21:05:05', '2', '4', 'Sale'),
    (NULL, '2023-05-27 21:30:13', '4', '4', 'Sale'),
    (NULL, '2023-05-27 23:05:13', '2', '4', 'Sale'),
    (NULL, '2023-05-28 12:00:50', '4', '1', 'Sale');


INSERT INTO `manufacturers` (`id`, `name`, `address`, `phone`)
VALUES 
    (NULL, 'Eva Pharma', '123 Fake Street, Cairo', '01012345678'),
    (NULL, 'Rameda', '456 Made Up Avenue, Giza', '01234567890'),
    (NULL, 'Pharco', '789 Nonexistent Road, Alexandria', '01509876543'),
    (NULL, 'Amoun', '321 Imaginary Boulevard, Luxor', '01098765432'),
    (NULL, 'Eipico', '654 Fictional Lane, Aswan', '01187654321'),
    (NULL, 'Memphis', '987 Pretend Place, Sharm El-Sheikh', '01276543210'),
    (NULL, 'Delta Pharma', '741 Imagined Street, Hurghada', '01565432109'),
    (NULL, 'Minapharm', '852 Fantasy Avenue, Dahab', '01011112222'),
    (NULL, 'Amgen', '369 Dreamland Boulevard, Marsa Alam', '01122223333'),
    (NULL, 'Chemipharm', '1234 Made-up Street, Alexandria', '01233334444');


INSERT INTO `medicines` (`id`, `name`, `manufacture_id`)
VALUES 
    (NULL, 'Paracetamol', '1'),
    (NULL, 'Amoxicillin', '2'),
    (NULL, 'Ciprofloxacin', '3'),
    (NULL, 'Omeprazole', '4'),
    (NULL, 'Amlodipine', '5'),
    (NULL, 'Metformin', '6'),
    (NULL, 'Simvastatin', '7'),
    (NULL, 'Losartan', '8'),
    (NULL, 'Atorvastatin', '3'),
    (NULL, 'Aspirin', '5'),
    (NULL, 'Ibuprofen', '9'),
    (NULL, 'Levofloxacin', '10');


INSERT INTO `inventory` (`id`, `med_id`, `purchase_price`, `selling_price`, `expiration_date`, `quantity`)
VALUES 
    (NULL, '1', '3', '5', '2027-05-11', '5'),
    (NULL, '2', '8', '10', '2027-05-11', '2'),
    (NULL, '3', '12', '15', '2030-05-11', '4'),
    (NULL, '4', '15', '20', '2025-02-07', '3'),
    (NULL, '5', '20', '25', '2025-02-09', '20'),
    (NULL, '6', '25', '30', '2029-02-09', '6'),
    (NULL, '7', '30', '35', '2028-02-09', '5'),
    (NULL, '8', '30', '40', '2028-02-10', '15'),
    (NULL, '9', '25', '45', '2028-02-10', '30'),
    (NULL, '10', '40', '50', '2028-02-10', '14'),
    (NULL, '11', '50', '55', '2030-01-01', '16'),
    (NULL, '12', '50', '70', '2030-01-01', '7'),
    (NULL, '1', '3', '5', '2050-01-01', '40'),
    (NULL, '7', '30', '40', '2030-02-09', '15'),
    (NULL, '9', '25', '45', '2030-10-15', '60'),
    (NULL, '2', '8', '10', '2027-05-11', '50'),
    (NULL, '3', '12', '15', '2030-05-11', '20'),
    (NULL, '5', '22', '25', '2025-02-09', '50');


INSERT INTO `invoice_details` (`invoice_id`, `inventory_id`, `quantity`)
VALUES 
    ('1', '2', '2'),
    ('1', '3', '5'),
    ('1', '6', '2'),
    ('1', '8', '6'),
    ('1', '9', '1'),
    ('1', '7', '3'),
    ('2', '4', '3'),
    ('2', '8', '2'),
    ('2', '6', '3'),
    ('3', '5', '6'),
    ('3', '2', '1'),
    ('4', '6', '1'),
    ('5', '3', '3'),
    ('6', '2', '1'),
    ('7', '2', '1'),
    ('7', '4', '2'),
    ('8', '5', '10'),
    ('9', '6', '2'),
    ('10', '3', '2'),
    ('11', '9', '1'),
    ('12', '5', '6');


INSERT INTO `expenses` (`id`, `name`, `description`, `amount`, `category`)
VALUES 
    (NULL, 'Cleaning Tools', 'item1, item2, item3', '10', 'Cleaning'),
    (NULL, 'Electricity Bill', '', '100', 'Bills'),
    (NULL, 'Taxes', '', '20', 'Bills'),
    (NULL, 'New Air Conditioner', '', '200', 'Others'),
    (NULL, 'Cleaning Tools2', '', '5', 'Cleaning');


INSERT INTO `members` (`id`, `name`, `phone`, `username`, `password`, `role`)
VALUES 
    (NULL, 'Adminstartor', '01000000000', 'admin', '$2y$10$kqStedpDjUQn1Od7Mvs6ouM2HuEjnR.LRcf/R0ndZOn33WLwa2n/.', 'Administrator'),
    (NULL, 'Staff', '01000000001', 'Staff', '$2y$10$kqStedpDjUQn1Od7Mvs6ouM2HuEjnR.LRcf/R0ndZOn33WLwa2n/.', 'Pharmacy Staff'),
    (NULL, 'Cashier', '01000000002', 'Cashier', '$2y$10$kqStedpDjUQn1Od7Mvs6ouM2HuEjnR.LRcf/R0ndZOn33WLwa2n/.', 'Cashier');