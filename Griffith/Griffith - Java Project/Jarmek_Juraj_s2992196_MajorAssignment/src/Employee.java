import java.sql.Date;

// We are creating a new constructor class
public class Employee {

	// we are creating private fields to store the data - I have added more fields since I was creating more queries that was easier to build with constructor instead of writing non-dry code in the main file
	private int emp_no;			
	private Date birth_date;
	private String first_name;
	private String last_name;
	private String gender;
	private Date hire_date;
	private int dept_no;
	private int salary;
	/**
	 * Constructor
	 * @param emp_no
	 * @param birth_date
	 * @param first_name
	 * @param last_name
	 * @param gender
	 * @param hire_date
	 */

//We are creating a a new default constructor that will be a super for the other specific constructor
	public Employee() {
		super();

	}

	/**
	 * 
	 * @param emp_no
	 * @param birth_date
	 * @param first_name
	 * @param last_name
	 * @param gender
	 * @param hire_date
	 */
// We are creating the first main constructor that we are using for the main table in case we need to send queries to the database
	public Employee(int emp_no, Date birth_date, String first_name, String last_name, String gender, Date hire_date) {
		this.emp_no = emp_no;
		this.birth_date = birth_date;
		this.first_name = first_name;
		this.last_name = last_name;
		this.gender = gender;
		this.hire_date = hire_date;
	}
// We are creating the second constructor so it can be used in the method option 5 to ask for the salary if we enter the employees number
	public Employee(int emp_no, int salary) {
		this.emp_no = emp_no;
		this.salary = salary;
	}
// We are creating the third constructor so it can be used in the option 6 when we ask for the last names and for the department nubmer
	public Employee(String last_name, int dept_no) {
		this.last_name = last_name;
		this.dept_no = dept_no;
	}

	/**
	 * 
	 * @return
	 */
// We are setting the getters and setters for the above parameters and constructors
	public int getEmpNo() {
		return emp_no;
	}

	 //Set the employee number of an Employee instance
	 //@param emp_number new employee number
	 
	 public void setEmpNumber(int emp_number) {
	 this.emp_no = emp_number;
	 }

	/**
	 * Get the first name of an Employee instance
	 * @return first name of the employee instance
	 */
	public String getFirstName() {
		return first_name;
	}
	
	/**
	 * Set the first name of an Employee instance
	 * @param first_name new first name
	 */
	public void setFirstName(String first_name) {
		this.first_name = first_name;
	}

	/**
	 * Get the last name of an Employee instance
	 * @return last name
	 */
	public String getLastName() {
		return last_name;
	}

	/**
	 * Set the last name of an Employee instance
	 * @param last_name last name
	 */
	public void setLastName(String last_name) {
		this.last_name = last_name;
	}

	/**
	 * Get the date of birth of an Employee instance
	 * @return date of birth
	 */
	public Date getDateofBirth() {
		return birth_date;
	}

	/**
	 * Set the date of birth of an Employee instance
	 * @param birth_date new birth date
	 */
	public void setBirthDate(Date birth_date) {
		this.birth_date = birth_date;
	}

	/**
	 * Get the gender of an Employee instance
	 * @return gender
	 */
	public String getGender() {
		return gender;
	}

	/**
	 * Set the gender of an Employee instance
	 * @param gender new gender
	 */
	public void setGender(String gender) {
		this.gender = gender;
	}

	/**
	 * Get the hire date of an employee instance
	 * @return hire date
	 */
	public Date getHireDate() {
		return hire_date;
	}

	/**
	 * Set the start date of an Employee instance
	 * @param hire_date new start date
	 */
	public void setHireDate(Date hire_date) {
		this.hire_date = hire_date;
	}
	
	public int getDeptNo() {
		return dept_no;
	}

	 //Set the department number of an Employee instance
	 //@param dep_number new employee number
	 
	public void setDepNo(int dep_number) {
		this.dept_no = dep_number;
	}
	
	public int getSalary() {
		return salary;
	}
		 
	public void setSalary(int sal) {
		this.salary = sal;
	}
	
	// Creating a to String method that will create an easy to read string so the above attributes can be print out the buffer
	public String toString(){
		// creating a string buffer
		StringBuffer sb = new StringBuffer();

		sb.append("\tempNo:			").append(this.emp_no);
		sb.append("\tfirstName:		").append(this.first_name);
		sb.append("\tlasttName:		").append(this.last_name);
		sb.append("\tbirthDate:		").append(this.birth_date);
		sb.append("\tgender:		").append(this.gender);
		sb.append("\thiretDate:		").append(this.hire_date);
		// returning it to be printed
		return sb.toString();
	} 
	
	
}
