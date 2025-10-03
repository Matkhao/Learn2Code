-- ข้อมูลตัวอย่างสำหรับ tbl_categories

INSERT INTO `tbl_categories` (`category_id`, `name`, `icon`, `created_at`) VALUES
(1, 'Frontend Development', 'fas fa-code', NOW()),
(5, 'Data Science', 'fas fa-chart-bar', NOW()),
(9, 'Programming Languages', 'fas fa-laptop-code', NOW()),
(10, 'Web Development', 'fas fa-globe', NOW()),
(11, 'Game Development', 'fas fa-gamepad', NOW()),
(15, 'DevOps & Tools', 'fas fa-tools', NOW());

-- เพิ่มหมวดหมู่อื่น ๆ ที่อาจใช้ในอนาคต
INSERT INTO `tbl_categories` (`category_id`, `name`, `icon`, `created_at`) VALUES
(2, 'Backend Development', 'fas fa-server', NOW()),
(3, 'Mobile Development', 'fas fa-mobile-alt', NOW()),
(4, 'Database', 'fas fa-database', NOW()),
(6, 'Machine Learning', 'fas fa-brain', NOW()),
(7, 'Cybersecurity', 'fas fa-shield-alt', NOW()),
(8, 'Cloud Computing', 'fas fa-cloud', NOW()),
(12, 'UI/UX Design', 'fas fa-paint-brush', NOW()),
(13, 'Digital Marketing', 'fas fa-bullhorn', NOW()),
(14, 'Project Management', 'fas fa-tasks', NOW());