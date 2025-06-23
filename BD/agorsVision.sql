CREATE DATABASE agorsVision;

USE agorsVision;

CREATE TABLE TYPES(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	TYPE VARCHAR(255)
);

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(255),
    email VARCHAR(255),
    PASSWORD VARCHAR(255),
    ACTIVE BOOLEAN DEFAULT TRUE,
    
    
    TYPE INT,
    USER INT,
    
    CONSTRAINT fk_types FOREIGN KEY (TYPE) REFERENCES TYPES(id),
    CONSTRAINT fk_u FOREIGN KEY (USER) REFERENCES users(id)
    
);

CREATE TABLE categorys (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(255),
    rate VARCHAR(255)
);

CREATE TABLE stokes (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(255),
    quantity VARCHAR(255),
    VALUE VARCHAR(255),
    price VARCHAR(255),
    attribution VARCHAR(255),

    ACTIVE BOOLEAN DEFAULT TRUE,
    
    category INT,
    USER INT,
    
    CONSTRAINT fk_categorys FOREIGN KEY (category) REFERENCES categorys(id),
    CONSTRAINT FK_Us FOREIGN KEY (USER) REFERENCES users(id)
);

CREATE TABLE products (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    quantity VARCHAR(255),
    
    stoke INT,
    USER INT,
    
    CONSTRAINT fk_stokes FOREIGN KEY (stoke) REFERENCES stokes(id),
    CONSTRAINT fk_users FOREIGN KEY (USER) REFERENCES users(id)
);

CREATE TABLE pays(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	pay VARCHAR(255)
);

CREATE TABLE sales (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    quantity VARCHAR(255),
    total VARCHAR(255),
    created_at VARCHAR(255),
    comission VARCHAR(255),
    
    pay INT,
    USER INT,
    product INT,
    
    CONSTRAINT fk_pays FOREIGN KEY (pay) REFERENCES pays(id),
    CONSTRAINT fk_user FOREIGN KEY (USER) REFERENCES users(id),
    CONSTRAINT fk_product FOREIGN KEY (product) REFERENCES products(id)
);

CREATE TABLE accounts(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	created_at VARCHAR(255),
	VALUE VARCHAR(255),
	USER INT,
	
	CONSTRAINT FK_use FOREIGN KEY (USER) REFERENCES users(id)
);


/*INSERT*/

INSERT INTO TYPES (TYPE)
	VALUES ("ADM"), ("VENDEDOR");

INSERT INTO categorys (category, rate)
	VALUES ("NATURA", "5"), ("BOTICARIO", "10"), ("ROUPA", "15");
	
INSERT INTO pays (pay)
	VALUES ("PIX"), ("DINHEIRO"), ("DÉBITO"), ("CRÉDITO");
	

-- Consultas para o dashboard

-- 1. Total de vendas
SELECT COUNT(id) AS total_sales FROM sales;

-- 2. Total de produtos vendidos e quantidade total
SELECT 
    COUNT(id) AS total_sales, 
    SUM(quantity) AS total_products_sold 
FROM sales;

-- 3. Receita total das vendas
SELECT SUM(total) AS total_revenue FROM sales;

-- 4. Receita por método de pagamento
SELECT 
    p.pay AS payment_method, 
    SUM(s.total) AS revenue 
FROM sales s
JOIN pays p ON s.pay = p.id
GROUP BY p.pay;

-- 5. Produtos mais vendidos
SELECT 
    st.NAME AS product_name, 
    SUM(s.quantity) AS total_sold 
FROM sales s
JOIN products p ON s.product = p.id
JOIN stokes st ON p.stoke = st.id
GROUP BY st.NAME
ORDER BY total_sold DESC
LIMIT 5;

-- 6. Quantidade de produtos por categoria
SELECT 
    c.category AS category_name, 
    COUNT(st.id) AS total_products 
FROM stokes st
JOIN categorys c ON st.category = c.id
GROUP BY c.category;

-- 7. Estoque total e valor total de produtos no estoque
SELECT 
    SUM(quantity) AS total_stock_quantity, 
    SUM(price * quantity) AS total_stock_value 
FROM stokes;

-- 8. Quantidade de produtos atribuídos por vendedor
SELECT 
    u.NAME AS seller_name, 
    SUM(p.quantity) AS total_products_assigned 
FROM products p
JOIN users u ON p.USER = u.id
GROUP BY u.NAME;

-- 9. Vendas por vendedor
SELECT 
    u.NAME AS seller_name, 
    COUNT(s.id) AS total_sales, 
    SUM(s.total) AS total_revenue 
FROM sales s
JOIN users u ON s.USER = u.id
GROUP BY u.NAME;

-- 10. Receita por categoria de produto
SELECT 
    c.category AS category_name, 
    SUM(s.total) AS total_revenue 
FROM sales s
JOIN products p ON s.product = p.id
JOIN stokes st ON p.stoke = st.id
JOIN categorys c ON st.category = c.id
GROUP BY c.category;

-- 11. Produtos com estoque baixo (menos de 10 unidades)
SELECT 
    NAME AS product_name, 
    quantity AS current_stock 
FROM stokes 
WHERE quantity < 10;

-- 12. Comissões por vendedor (se aplicável)
SELECT 
    u.NAME AS seller_name, 
    SUM(s.total * (c.commission / 100)) AS total_commission 
FROM sales s
JOIN users u ON s.USER = u.id
JOIN products p ON s.product = p.id
JOIN stokes st ON p.stoke = st.id
JOIN categorys c ON st.category = c.id
GROUP BY u.NAME;

-- 13. Vendas por mês
SELECT 
    DATE_FORMAT(created_at, '%Y-%m') AS sales_month, 
    COUNT(id) AS total_sales, 
    SUM(total) AS total_revenue 
FROM sales 
GROUP BY sales_month
ORDER BY sales_month DESC;
