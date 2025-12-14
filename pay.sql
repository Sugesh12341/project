CREATE TABLE payment (
  id INT AUTO_INCREMENT PRIMARY KEY,
  invoice_no VARCHAR(50) NOT NULL,
  invoice_date DATE NOT NULL,
  bike_name VARCHAR(100) NOT NULL,
  rental_days INT NOT NULL,
  rate_per_day DOUBLE NOT NULL,
  total_amount DOUBLE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
