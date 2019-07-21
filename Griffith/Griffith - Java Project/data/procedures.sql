
-- This section drops procedures in case they exist, which helps us avoid erors
DROP PROCEDURE IF EXISTS getEmployeeCount;
DROP PROCEDURE IF EXISTS getAllEmployeesDetails;
DROP PROCEDURE IF EXISTS getEmployeeByLastName;
DROP PROCEDURE IF EXISTS newEmployee;
DROP PROCEDURE IF EXISTS getEmployeeSalary;
DROP PROCEDURE IF EXISTS getEmployeeDepartmentNo;
-- Option 0 - there is no procedure under this option

-- Option 1 - We create a procedure to count the employees and display the count as num
CREATE PROCEDURE getEmployeeCount()
SELECT COUNT(emp_no) AS num FROM oop_employees;

-- Option 2 - We create the procedure to show all the employee details by showing all the records from the oop_employees tables
CREATE PROCEDURE getAllEmployeesDetails()
SELECT * FROM oop_employees;

-- Option 3 - We create the procedure to show all the records from an employee when we enter the employee's last name
CREATE PROCEDURE getEmployeeByLastName (IN input_last_name VARCHAR(16))
SELECT * FROM oop_employees WHERE last_name = input_last_name;


-- Option 4 - We create a procedure where we can enter new employee details into the databases, I wanted to do a cascade update with other tables, but the tables are not linked with foreign keys and the delimiter is disabled in the script runner 
CREATE PROCEDURE newEmployee(emp_no INT(11), birth_date DATE, first_name VARCHAR(14) , last_name VARCHAR(16) , gender CHAR(1), hire_date DATE)
INSERT INTO oop_employees VALUES(emp_no, birth_date, first_name, last_name, gender, hire_date);


-- Option 5 - I have create an employee Salary query where we show an employee's salary when we enter the employee's number. I could have done that with any columns, like the first name, but I wanted to change it up.
-- We have create also an inner join so we can take query results from two tables
CREATE PROCEDURE getEmployeeSalary (IN input_emp_no INT(11))
SELECT oop_employees.emp_no, oop_salaries.salary FROM oop_employees INNER JOIN oop_salaries ON oop_employees.emp_no = oop_salaries.emp_no WHERE oop_employees.emp_no = input_emp_no;


-- Option 6 -
-- We create an an additional query with two tables. We show the employee's last name and their department number. 
CREATE PROCEDURE getEmployeeDepartmentNo()
SELECT oop_employees.last_name, oop_dept_emp.dept_no from oop_employees INNER JOIN oop_dept_emp ON oop_employees.emp_no = oop_dept_emp.emp_no;
