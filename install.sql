
-- SmartComfy Comments schema
CREATE TABLE IF NOT EXISTS comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id VARCHAR(255),
  parent_id INT NULL,
  user_id INT NULL,
  guest_name VARCHAR(100),
  guest_email VARCHAR(150),
  content TEXT,
  status ENUM('approved','pending','spam') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
