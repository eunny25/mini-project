-- ================= ADMIN USER INITIALIZATION =================
-- This script automatically creates the admin user 'Eunice Edwin' in the database
-- Password: eunny@#25

USE internship_db;

-- Insert admin user (using SHA2 for password hashing)
INSERT INTO users (name, email, password, role, phone, is_active, created_at, updated_at)
VALUES (
    'Eunice Edwin',
    'eune.2502@gmail.com',
    SHA2('eunny@#25', 256),  -- Hashed password using SHA256
    'admin',
    '0678154511',
    TRUE,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
)
ON DUPLICATE KEY UPDATE
    updated_at = CURRENT_TIMESTAMP;

-- Verify admin user was created
SELECT 'Admin user created successfully!' AS status;
SELECT id, name, email, role, created_at FROM users WHERE role = 'admin';
