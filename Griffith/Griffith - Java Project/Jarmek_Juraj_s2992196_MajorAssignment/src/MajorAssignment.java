
// importing the 
import java.sql.Connection;
import java.sql.Date;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
//import java.util.Arrays;
import java.util.Scanner;

import util.DBConnect;
/**
 * @author Alex Cronin - modified by Juraj Jarmek
 * I have delete most of the other comments from the java file since I wanted to have more clear space for commmenting
 */
// we are creating the Major Assignment class where we will store most of our input for this assignment
public class MajorAssignment {

//	creating the main method
	public static void main(String[] args) {
		System.out.println("MajorAssignment.java - starting main method\n");

		// Create a scanner to accept input from the user
		Scanner sc = new Scanner(System.in);
		// Create a DBConnect object and open a  connection
		DBConnect dbc2 = new DBConnect();
//		input your details
		dbc2.setUpForKnuthMySQL("s2992196", "iestadom", "s2992196", "s2992196", "iestadom");
		// open the connection
		dbc2.openConnection();
// creating a do loop that will loop the option once
		do {
			// Menu of the application
//			amend the menu with the new options
			System.out.println("\n===========================================================");
			System.out.println("USER MENU");
			System.out.println("Please select an option by typing the corresponding number.");
			System.out.println("0. Exit");				
			System.out.println("1. Display the count of the employees");
			System.out.println("2. Display records of all employees");
			System.out.println("3. Search for an employee by last name");
			System.out.println("4. Add a new employee");
			System.out.println("5. Show the salary of an employee by entering their number.");				
			System.out.println("6. Show all the employee's department number");
			System.out.println("===========================================================");
			System.out.print("option> ");

			// store the selected option number
			int option = sc.nextInt();

			// 0. exit the program
			
			if (option == 0) {
				System.out.println("Exiting the program");
				break; //exit the while loop
//				when we exit the loop the program stops
			}

			// 1. displaying all employees
			else if (option == 1) {
				int result = MajorAssignment.getEmployeeCount(dbc2.getConnection());
				System.out.println(result);
//				this was done already in the class
				// Output the result of the getEmployeeCount method which is implemented after the main method
//				We have written the method, like all the other get methods written in the options, at the bottom of the document
			}

			// 2. displaying all employees 
			else if (option == 2) {
//				we are writing the second option which will show all the employees in the oop_employees table
//				we are using the get all employee details method that we have written at the end of the document
				Employee [] result = MajorAssignment.getAllEmployeesDetails(dbc2.getConnection());
				for (Employee e:result) {
					System.out.println(e);
				}
			}

			// 3. search for an employee by name
//			We are writing the third option which outputs all the details from an employee when we enter their last name.
			else if (option == 3) {

				// Use the getEmployeebyLastName method			
//				Ask for the user input
				System.out.println("Please enter the last name of the employee you are searching for: ");

				String input_last_name = sc.next();

				getEmployeeByLastName(dbc2.getConnection(), input_last_name);

			}
			
			// 4. adding an employee

			else if (option == 4) {

				

				// We are asking for the user input and storing it with a constructor from employee.java

				Employee newEmployee = new Employee();

				System.out.println("Please enter the employee's employee number: ");

				int emp_no = sc.nextInt();

				newEmployee.setEmpNumber(emp_no);

				System.out.println("Please enter the employee's date of birth in the format yyyy-MM-dd: ");

				String temp = sc.next();

				Date dob = Date.valueOf(temp);

				newEmployee.setBirthDate(dob);

				System.out.println("Please enter the employee's first name: ");

				String f_name = sc.next();

				newEmployee.setFirstName(f_name);

				System.out.println("Please enter the employee's last name: ");

				String l_name = sc.next();

				newEmployee.setLastName(l_name);

				System.out.println("Please enter the employee's gender (M/F): ");

				String gender = sc.next();

				newEmployee.setGender(gender);

				System.out.println("Please enter the employee start date in the format yyyy-MM-dd: ");

				String temp2 = sc.next();

				Date hire_date = Date.valueOf(temp2); 

				newEmployee.setHireDate(hire_date);

				
//				We are inserting the input into a string and formating it accordingly
				String insertEmp = String.format("CALL newEmployee('%d', '%s', '%s', '%s', '%s', '%s');", newEmployee.getEmpNo(), newEmployee.getDateofBirth(), newEmployee.getFirstName(), newEmployee.getLastName(), newEmployee.getGender(), newEmployee.getHireDate());

				
//				Saving the formated String and calling the newEmployee method written below
				newEmployee(dbc2.getConnection(), insertEmp);

			}
//			I have written the option 5 to show us employees salary when we ask for the employee nubmer
			// 5. Additional functionality 
			else if (option == 5) {		

				System.out.println("Please enter the number of the employee whose salary you would like to look up: ");

				int input_emp_no = sc.nextInt();
//				Storing the salary and calling the method
				getEmployeeSalary(dbc2.getConnection(), input_emp_no);

			
				
			}	
			// 6. Additional functionality 
//			I have added the sixth option to show us all the employees with their last names and the department numbers in which they belog
			else if (option == 6) {
				getEmployeeDepartmentNo(dbc2.getConnection());
			}	

			// unknown option
//			this will be printed in case there is no valid option, meaning if the numbers 0-6 are not entered
			else {
				System.out.println("Invalid option.");
			}
		}
		
//		the loop runs unless 0 is selected
		while(true); //loop until option 0 is selected

		// Close the connection
		dbc2.closeConnection();
		// Close the scanner
		sc.close();
//		we are calling that the program has ended
		System.out.println("MajorAssignment.java - ending main method\n");

	}
	
	/**
	 * We are calling all the methods that we that we have called in the above if else statements and options
	 * 
	 * Option 0 - Exit the program. No method to call SQL required. 
	 */

	/**
	 * Option 1 - Display the count of the employees
	 * @param conn - the connection to the MySQL schema 
	 * @return count of Employees
	 */
	public static int getEmployeeCount(Connection conn) {
		int num = -1;
		try {
			// Create the SQL query string which uses the  "getEmployeeCount" stored procedure in the employee 
			String sql = "CALL getEmployeeCount()";
			// Create a new SQL statement 
			Statement st = conn.createStatement();
			// Create a new results set which store the value returned by the  when the SQL statement is executed 
			ResultSet rs = st.executeQuery(sql);
			// While there are still elements in the results set
			while (rs.next()) 
				// assign the next int in the results set to num
				num = rs.getInt(1); 
			// close the results set
			rs.close(); 
			// close the statement
//			This process will be used similarly in the other methods also, with modifications
			st.close(); 
		}
//		We call the SQL exception if there are any errors with calling the SQL procedures but not in the java file itself.
		catch (SQLException e) {
			System.out.println("Error in getEmployeeCount");
			e.printStackTrace();
		}
//		We are returning the result
		return num;		
	}

	/**
	 * Option 2 - Display records of all the employees 
	 * @param conn - the connection to the MySQL schema 
	 */
	public static Employee[] getAllEmployeesDetails(Connection conn) {
		Employee [] empArray = new Employee[11];
//		We are now creating a second option method and showing all the employees details in it
		try {
			// Create the SQL query string which uses the  "getEmployeeCount" stored procedure in the employee 
			String sql = "CALL getAllEmployeesDetails()";
			// Create a new SQL statement 
			Statement st = conn.createStatement();
			// Create a new results set which store the value returned by the  when the SQL statement is executed 
			ResultSet rs = st.executeQuery(sql); 
			// While there are still elements in the results set
			int i=0;
//			we are running a while loop and storing all the sql results in the main constructor
			while (rs.next()) {
				empArray[i++] = new Employee(rs.getInt("emp_no"), rs.getDate("birth_date"), rs.getString("first_name"),rs.getString("last_name"), rs.getString("gender"), rs.getDate("hire_date"));
			}
			// close the results set
			rs.close(); 
			// close the statement
			st.close(); 
		}
		catch (SQLException e) {
			System.out.println("Error in getAllEmployeesDetails");
			e.printStackTrace();
		}
//		return the array
		return empArray;
	}

	/**

	 * Option 3 - Search for an employee by last name

	 * @param conn - the connection to the MySQL schema 

	 * @param ip_last_name - Last name provided.

	 * @return

	 */
//	calling the method in which we will call all the results from a particular employee when we call their last name
	public static Employee[] getEmployeeByLastName(Connection conn, String input_last_name) {

		Employee[] empArray2 = new Employee[1];
//		running the loop with the input from the option and we are storing the last name so we ca use it below
		try {

			// Create an SQL query that uses the procedure stored in the procedures.sql file 

			String sql = "CALL getEmployeeByLastName(\"" + input_last_name + "\")"; 
			// Create an SQL query
			Statement st = conn.createStatement();
			// generate a result 
			ResultSet rs = st.executeQuery(sql);

//			running a similar loop from get all employees method where we are showing the details from the employee
			
			int i=0;

			while (rs.next()) {

				empArray2[i] = new Employee(rs.getInt("emp_no"), rs.getDate("birth_date"), rs.getString("first_name"),rs.getString("last_name"), rs.getString("gender"), rs.getDate("hire_date")); 

				//Print it out

				System.out.println(empArray2[i++].toString());

			}
			
			// close the result and the statement			
			rs.close();
			// close the statement
			st.close();

		}

		catch (SQLException e) {

			System.out.println("Error in getEmployeeByLastName");

			e.printStackTrace();

		}

		return empArray2;

	}

	/**
	 *  Option 4 - Add a new employee. This method need only alter the Employee table
	 * @param conn - the connection to the MySQL schema 
	 * @param emp - the employee to add
	 */
//		We are creating the new employee method where we will execute the string and store it into our database 
		public static void newEmployee(Connection conn, String sql) {

			try {
			      // Create an SQL procedure
			      Statement st = conn.createStatement();
			      st.executeUpdate(sql);
			      System.out.println("The update was successful."); 
			      System.out.println(sql);
			      // close the statement
			      st.close();
			}
		
			catch(SQLException e) {
			System.out.println("Error in newEmployee");
			System.out.println(sql);
			}
		}
		
//		Option 5
//		We are creating the employee salary method where we will implement our code to get the salary when we enter an employee nubmer
		public static Employee [] getEmployeeSalary(Connection conn, int input_emp_no) {
//			We are using some code from the get employee by last name
			Employee [] empSalaryQuery = new Employee[1];

			try {

				// Create an SQL query that uses the procedure stored in the procedures.sql file 
//				Storing the input from the user into the query
				String sql = "CALL getEmployeeSalary(\"" + input_emp_no + "\")"; 
				// Create an SQL query
				Statement st = conn.createStatement();
				// generate a result 
				ResultSet rs = st.executeQuery(sql);

//				calling the database results and printing it to the console
				while (rs.next()) {
					int emp_no = rs.getInt("emp_no");
					int salary = rs.getInt("salary");
			        System.out.println(emp_no + "\t" + salary);
				}
				// close the result and the statement
				rs.close();

				st.close();

			}

			catch (SQLException e) {

				System.out.println("Error in getEmployeeSalary");

				e.printStackTrace();

			}

			return empSalaryQuery;
		}
		
//		Option 6
//		Writing the last method where we will get all the employee last names and the number of their department and showing it in the console
		public static Employee [] getEmployeeDepartmentNo(Connection conn) {
			Employee [] empDeptNo = new Employee[11];
//			We are using a similar loop to the loop above
			try {
				// Create the SQL query string which uses the  "getEmployeeDepartmentNo" stored procedure in the employee 
				String sql = "CALL getEmployeeDepartmentNo()";
				// Create a new SQL statement 
				Statement st = conn.createStatement();
				// Create a new results set which store the value returned by the  when the SQL statement is executed 
				ResultSet rs = st.executeQuery(sql); 
				// While there are still elements in the results set
				
				while (rs.next()) {
					String last_name = rs.getString("last_name");
					String dept_no = rs.getString("dept_no");
			        System.out.println(last_name + "\t" + dept_no);
				
				}
				// close the results set
				rs.close();
				// close the statement
				st.close(); 
			}
			catch (SQLException e) {
				System.out.println("Error in getEmployeeCount");
				e.printStackTrace();
			}
			
			return empDeptNo;
		}
		
}
