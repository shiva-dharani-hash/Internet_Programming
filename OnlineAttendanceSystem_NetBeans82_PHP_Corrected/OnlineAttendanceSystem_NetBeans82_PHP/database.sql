CREATE DATABASE IF NOT EXISTS attendance_db;
USE attendance_db;

DROP TABLE IF EXISTS attendance;
DROP TABLE IF EXISTS subjects;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS faculty;

CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    register_no VARCHAR(30) UNIQUE NOT NULL,
    email VARCHAR(100),
    department VARCHAR(100),
    year INT,
    section VARCHAR(10),
    password VARCHAR(100) NOT NULL
);

CREATE TABLE faculty (
    faculty_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    department VARCHAR(100),
    designation VARCHAR(50),
    password VARCHAR(100) NOT NULL
);

CREATE TABLE subjects (
    subject_id INT AUTO_INCREMENT PRIMARY KEY,
    subject_code VARCHAR(30) UNIQUE NOT NULL,
    subject_name VARCHAR(100) NOT NULL,
    faculty_id INT,
    FOREIGN KEY (faculty_id) REFERENCES faculty(faculty_id)
        ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE attendance (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    subject_id INT NOT NULL,
    attendance_date DATE NOT NULL,
    status VARCHAR(10) NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(subject_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY unique_attendance (student_id, subject_id, attendance_date)
);

INSERT INTO faculty (name, email, department, designation, password)
VALUES ('Kumar', 'kumar@gmail.com', 'Computer Science and Engineering', 'Assistant Professor', '1234');

INSERT INTO students (name, register_no, email, department, year, section, password)
VALUES
('Shiva Dharani', '24UCS003', 'shiva@example.com', 'Computer Science and Engineering', 2, 'A', '1234'),
('Arun Kumar', '24UCS004', 'arun@example.com', 'Computer Science and Engineering', 2, 'A', '1234'),
('Priya', '24UCS005', 'priya@example.com', 'Computer Science and Engineering', 2, 'A', '1234'),
('Rahul', '24UCS006', 'rahul@example.com', 'Computer Science and Engineering', 2, 'A', '1234');

INSERT INTO subjects (subject_code, subject_name, faculty_id)
VALUES
('CS501', 'Internet Programming', 1),
('CS502', 'Database Management Systems', 1),
('CS503', 'Software Engineering', 1);

INSERT INTO attendance (student_id, subject_id, attendance_date, status)
VALUES
(1,1,'2026-09-01','Present'),
(1,1,'2026-09-02','Present'),
(1,1,'2026-09-03','Absent'),
(1,1,'2026-09-04','Present'),
(1,2,'2026-09-01','Present'),
(1,2,'2026-09-02','Absent'),
(1,2,'2026-09-03','Present'),
(1,2,'2026-09-04','Present'),
(1,3,'2026-09-01','Present'),
(1,3,'2026-09-02','Present'),
(1,3,'2026-09-03','Present'),
(1,3,'2026-09-04','Absent'),

(2,1,'2026-09-01','Present'),
(2,1,'2026-09-02','Absent'),
(2,1,'2026-09-03','Present'),
(2,2,'2026-09-01','Present'),
(2,2,'2026-09-02','Present'),
(2,2,'2026-09-03','Present'),

(3,1,'2026-09-01','Present'),
(3,1,'2026-09-02','Present'),
(3,1,'2026-09-03','Present'),
(3,2,'2026-09-01','Absent'),
(3,2,'2026-09-02','Present'),
(3,2,'2026-09-03','Present'),

(4,1,'2026-09-01','Absent'),
(4,1,'2026-09-02','Present'),
(4,1,'2026-09-03','Present'),
(4,3,'2026-09-01','Present'),
(4,3,'2026-09-02','Present'),
(4,3,'2026-09-03','Absent');
