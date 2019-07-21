package util;

/**
 * DO NOT EDIT THIS FILE
 * 
 * This file facilitates the creation of a JDBC driver to a MySQL database which can be contained within
 * an SSH tunnel if so desired.
 * 
 * Class adapted from http://cryptofreek.org/2012/06/06/howto-jdbc-over-an-ssh-tunnel/ by Alex Cronin 26 NOv 2015
 */
import java.sql.Connection;
import java.sql.Date;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.Properties;

//import from JSch (Java Secure Channel) jar file - http://www.jcraft.com/jsch/ 
import com.jcraft.jsch.JSch;
import com.jcraft.jsch.JSchException;
import com.jcraft.jsch.Session;

public class DBConnect
{
	
	boolean sshTunnelRequired; 						// Set to true if an SSH tunnel is required to connect to a MySQL server on a remote host over SSH. Set to false if you are connecting to a mMySQL server on your local machine
	private String mysqlUsername;                	// MySQL login username
	private String mysqlPassword;                	// MySQL login password
	private String mysqlDatabaseName;				// database name
	private int localPort;                   		// local port number.  
													// - If the MySQL server is on your local machine this is the port it is running on. 
													// - If the MySQL server is on a remote machine this is the port you are forwarding on your local machine 

	private String sshUsername;                 	// SSH login username
	private String sshPassword;             		// SSH login password
	private String sshRemoteHost;  					// hostname or ip or SSH server
	private String mysqlHost;						// hostname or ip of the database server (from the perspective of your connection normally localhost) 
	private int remoteMySQLPort;             		// remote port number of MySQL server 
	private int shhRemotePort;                		// remote SSH host port number
	
	public  Connection connection = null;			// SQL connection object
	public  Statement statement = null;				// SQL statement to be executed
	public  ResultSet resultSet = null;				// result returned by the sql server
	public  Session session;						// SHH tunnel session
	
	/**
	 * Sets the variable for a connection to a MySQL server running on your local machine
	 * @param mysqlUsername
	 * @param mysqlPassword
	 * @param mysqlDatabaseName
	 */
	public void setUpForLocalMySQL(String mysqlUsername, String mysqlPassword, String mysqlDatabaseName) {
		this.mysqlUsername = mysqlUsername;
		this.mysqlPassword = mysqlPassword;
		this.mysqlDatabaseName = mysqlDatabaseName;
		this.sshTunnelRequired = false;
		this.mysqlHost="localhost";
		this.localPort=3306;
	}
	
	/**
	 * Sets the variable for a connection to a MySQL server running on knuth.gcd.ie 
	 * @param mysqlUsername
	 * @param mysqlPassword
	 * @param mysqlDatabaseName
	 * @param sshUsername
	 * @param sshPassword
	 */
	public void setUpForKnuthMySQL(String mysqlUsername, String mysqlPassword, String mysqlDatabaseName, String sshUsername, String sshPassword) {
		this.mysqlUsername = mysqlUsername;
		this.mysqlPassword = mysqlPassword;
		this.mysqlDatabaseName = mysqlDatabaseName;
		this.sshUsername = sshUsername;
		this.sshPassword = sshPassword;
		this.sshTunnelRequired = true;
		this.sshRemoteHost = "knuth.gcd.ie"; 
		this.shhRemotePort = 22;                     
		this.localPort = 3310;           	
		this.mysqlHost="localhost"; 
		this.remoteMySQLPort = 3306;
	}

	/**
	 * Open a connection with MySQL server. If there is an SSH Tunnel required it will open this too. 
	 * @return connection to a MySQL server
	 */
	public Connection openConnection(){
		if(sshTunnelRequired){ // if you are connecting to MySQL server on knuth (remote server)
			try{// open an SSH tunnel to the remote host using the variables above
				openSSHTunnel(sshUsername, sshPassword, sshRemoteHost, shhRemotePort, mysqlHost, localPort, remoteMySQLPort);
			}
			catch( Exception e ){
				e.printStackTrace();
			}
		}
		else{ 	//if you are connecting to MySQL server on your laptop
			
		}
		try{
			// create a new JDBC driver to facilitate the conversion of MySQL to java and vice versa
			Class.forName("com.mysql.jdbc.Driver").newInstance();

			// connect to the MySQL database through the SSH tunnel you have created using the variable above
			String jdbcConnectionString = "jdbc:mysql://"+mysqlHost+":"+localPort+"/"+mysqlDatabaseName+"?user="+mysqlUsername+"&password="+mysqlPassword;
			System.out.println("\nMySQL Connecting *********************************************************************************************************************");
			System.out.println("JDBC connection string "+jdbcConnectionString);
			connection = DriverManager.getConnection(jdbcConnectionString);
			System.out.println("Success: MySQL connection open");

			// testing connection 
			testConnection();

		}
		// catch various exceptions and print error messages
		catch (SQLException e){ 
			System.err.println("> SQLException: " + e.getMessage());
			e.printStackTrace();
		}
		catch (InstantiationException e) {
			System.err.println("> InstantiationException: " + e.getMessage());
			e.printStackTrace();
		}
		catch (IllegalAccessException e) {
			System.err.println("> IllegalAccessException: " + e.getMessage());
			e.printStackTrace();
		}
		catch (ClassNotFoundException e) {
			System.err.println("> ClassNotFoundException: " + e.getMessage());
			e.printStackTrace();
		}
		//return the connection
		return connection;
	}
	/**
	 * Close the connection to MySQL database. If there is an SSH tunnel open it will close this too.
	 * @param connection
	 */
	public void closeConnection(){
		System.out.println("\nMySQL Connection Closing ****************************************************************************************************************");
		try {
			connection.close(); // close database connection
			System.out.println("Success: MySQL connection closed.");
			if(sshTunnelRequired)
				closeSshTunnel();
		} catch (SQLException e) {
			System.out.println("Error: Could not close MySQL connection");
			System.err.println(e);	
			e.printStackTrace();}
	}

	/**
	 * Open SSH Tunnel to SSH server and forward the specified port on the local machine to the MySQL port on the MySQL server on the SSH server
	 * @param sshUser SSH username
	 * @param sshPassword SSH password
	 * @param sshHost hostname or IP of SSH server
	 * @param sshPort SSH port on SSH server
	 * @param remoteHost hostname or IP of MySQL server on SSH server (from the perspective of the SSH Server)
	 * @param localPort port on the local machine to be forwarded
	 * @param remotePort MySQL port on remoteHost 
	 * @throws JSchException exception
	 */
	private void openSSHTunnel( String sshUser, String sshPassword, String sshHost, int sshPort, String remoteHost, int localPort, int remotePort ) throws JSchException
	{
		final JSch jsch = new JSch();							// create a new Java Secure Channel
		session = jsch.getSession( sshUser, sshHost, sshPort);	// get the tunnel
		session.setPassword(sshPassword );						// set the password for the tunnel

		final Properties config = new Properties();				// create a properties object 
		config.put( "StrictHostKeyChecking", "no" );			// set some properties
		session.setConfig( config );							// set the properties object to the tunnel

		session.connect();										// open the tunnel
		System.out.println("\nSSH Connecting ***********************************************************************************************************************");
		System.out.println("Success: SSH tunnel open - you are connecting to "+sshHost+ "on port "+sshPort+ " with username " + sshUser);

		// set up port forwarding from a port on your local machine to a port on the MySQL server on the SHH server
		session.setPortForwardingL(localPort, remoteHost, remotePort);							
		// output a list of the ports being forwarded 
		System.out.println("Success: Port forwarded - You have forwared port "+ localPort + " on the local machine to port " + remotePort + " on " + remoteHost + " on " +sshRemoteHost);
	}

	/**
	 * Close SSH tunnel to a remote server
	 */
	private void closeSshTunnel(){
		try {
			// remove the port forwarding and output a status message
			System.out.println("\nSSH Connection Closing ******************************************************************************************************************");
			session.delPortForwardingL(localPort);
			System.out.println("Success: Port forwarding removed");
			// catch any exceptions	
		} catch (JSchException e) {
			System.out.println("Error: port forwarding removal issue");
			e.printStackTrace();
		}
		// disconnect the SSH tunnel
		session.disconnect();
		System.out.println("Success: SSH tunnel closed\n");
	}

	/**
	 * Test the connection by printing out the first 10 records of the oop_employees table
	 */
	private void testConnection(){
		try {
			statement = connection.createStatement(); 							// create an SQL statement
			resultSet = statement.executeQuery("SELECT * from oop_employees");  // retrieve an SQL results set

			// output the results set to the user
			System.out.println("\nTesting connection by printing out the first 10 employees");
			System.out.println("#\tBirthDate \tFName \tLName \tGender \tHireDate");

			// print out the first 10 records from the resultSet to the console (screen) using a while loop
			int i=0;
			while (resultSet.next() & i<10){
				int emp_no = resultSet.getInt("emp_no");
				Date birth_date = resultSet.getDate("birth_date");
				String first_Name = resultSet.getString("first_name");
				String last_Name = resultSet.getString("last_name");
				String gender = resultSet.getString("gender");
				Date hire_date = resultSet.getDate("hire_date");
				// "\t" mean tab
				System.out.println(emp_no + "\t" + birth_date + "\t" + first_Name + "\t" + last_Name + "\t" + gender + "\t" + hire_date );
				i++;
			}
			statement.close(); // close the SQL statement
			resultSet.close(); // close the results set
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}

	/**
	 * Get the connection to the MySQL server which has the option of running inside an SSH Tunnel
	 * @return
	 */
	public  Connection getConnection() {
		return connection;
	}

	/**
	 * Set the connection to the MySQL server which has the option of running inside an SSH Tunnel
	 */
	public  void setConnection(Connection connection) {
		this.connection = connection;
	}
	/**
	 * test the connection and disconnection process twice to ensure that port forwarding is removed
	 * @param args
	 */
	public static void main(String[] args) {
		System.out.println("DBConnect.java main method starting");
		
		// To test connection to MySQL server on local machine uncomment lines below and provide suitable parameters  
//		DBConnect dbc1 = new DBConnect();
//		dbc1.setUpForLocalMySQL("myUsername", "myPassword", "myDatabaseName");
//		dbc1.openConnection();
//		dbc1.closeConnection();
		
		// To test connection to MySQL server on knuth uncomment lines below and provide suitable parameters  
		DBConnect dbc2 = new DBConnect();
		dbc2.setUpForKnuthMySQL("s2992196", "iestadom", "s2992196", "s2992196", "iestadom");
		dbc2.openConnection();
		dbc2.closeConnection();
		
		System.out.println("DBConnect.java main method complete");
	}


}


