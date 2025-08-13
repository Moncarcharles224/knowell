

CREATE DATABASE IF NOT EXISTS courses_quiz_db;

USE courses_quiz_db;


CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(255) NOT NULL UNIQUE
);


CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    question_text TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_option CHAR(1) NOT NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS user_progress (
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    score INT NOT NULL,
    PRIMARY KEY (user_id, course_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

INSERT INTO courses (course_name) VALUES
('Python'),
('Java'),
('JavaScript'),
('C++'),
('SQL');

INSERT INTO questions (course_id, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES
(1, 'What is the correct file extension for Python files?', '.pyt', '.py', '.python', '.pth', 'b'),
(1, 'What is the output of `print(type([]))` in Python?', '<class ''list''>', '<class ''array''>', '<class ''tuple''>', '<class ''dict''>', 'a'),
(1, 'Which keyword is used for defining a function in Python?', 'func', 'def', 'function', 'define', 'b'),
(1, 'How do you create a comment in Python?', '// This is a comment', '# This is a comment', '', '/* This is a comment */', 'b'),
(1, 'What is the correct way to import the math module?', 'import "math"', 'include math', 'import math', 'use math', 'c'),

(2, 'Which keyword is used to define a class in Java?', 'class', 'Class', 'obj', 'object', 'a'),
(2, 'Which of the following is a primitive data type in Java?', 'String', 'Object', 'Array', 'int', 'd'),
(2, 'What does the `static` keyword mean in Java?', 'The variable belongs to the class and not an instance', 'The variable is constant', 'The method can only be called from a static method', 'The variable can only be accessed once', 'a'),
(2, 'Which of these is used for a single-line comment in Java?', '//', '/*', '--', '<!--', 'a'),
(2, 'What is the entry point method for a Java application?', 'main()', 'start()', 'run()', 'public main()', 'a'),

(3, 'Which company developed JavaScript?', 'Microsoft', 'Google', 'Netscape', 'Oracle', 'c'),
(3, 'What is the correct syntax for a JavaScript arrow function?', 'function() => {}', '() => {}', '=> {}', 'func() => {}', 'b'),
(3, 'How do you declare a constant in JavaScript?', 'var', 'let', 'const', 'constant', 'c'),
(3, 'What does `===` do in JavaScript?', 'Checks for equality of value only', 'Assigns a value', 'Checks for equality of value and type', 'Checks if a value is true', 'c'),
(3, 'Which of the following is an example of a JavaScript framework?', 'Flask', 'Django', 'React', 'Ruby on Rails', 'c'),

(4, 'What is the standard library for I/O operations in C++?', '<iostream>', '<stdio.h>', '<stdlib>', '<vector>', 'a'),
(4, 'How do you declare a constant variable in C++?', 'const int x = 10;', 'int const x = 10;', 'constant x = 10;', 'define x = 10;', 'a'),
(4, 'Which of the following is a correct way to comment out multiple lines?', '// This is a comment', '/* This is a comment */', '# This is a comment', '-- This is a comment', 'b'),
(4, 'What is the purpose of the `virtual` keyword in C++?', 'To declare a virtual machine', 'To enable polymorphism', 'To create a static method', 'To define a constant variable', 'b'),
(4, 'Which operator is used to access members of a struct or class using a pointer?', '->', '.', '::', '&', 'a'),

(5, 'What does SQL stand for?', 'Structured Query Language', 'Standard Query Language', 'Sequential Query Language', 'Simple Query Logic', 'a'),
(5, 'Which SQL command is used to extract data from a database?', 'GET', 'SELECT', 'EXTRACT', 'RETRIEVE', 'b'),
(5, 'Which SQL command is used to insert new data into a database?', 'INSERT INTO', 'ADD NEW', 'CREATE ROW', 'INSERT NEW', 'a'),
(5, 'Which of the following is a primary key constraint?', 'UNIQUE', 'NOT NULL', 'FOREIGN KEY', 'PRIMARY KEY', 'd'),
(5, 'How do you add a new column to an existing table?', 'ADD COLUMN', 'ALTER TABLE', 'UPDATE TABLE', 'CREATE COLUMN', 'b');