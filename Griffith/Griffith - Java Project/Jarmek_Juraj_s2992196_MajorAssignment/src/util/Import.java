package util;

import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.sql.Connection;
import java.sql.SQLException;

/**
 * ONLY EDIT LINES WHICH HAVE THE COMMENT "TODO EDIT THIS LINE" FOLLOWING THEM
 * 
 * Used to import SQL procedures from a specified file to the database across a specified connection
 * Uses an Apache library to read the data in the CSV files
 * - https://commons.apache.org/proper/commons-csv/user-guide.html
 * 
 * @author Original Karl, edited by Alex Cronin on 25 Nov 2018 
 *
 */
public class Import {	

	/**
	 * Imports a set of procedures in the specified SQL file to the specified database 
	 * @param args
	 */
	public static void main(String[] args) {
		System.out.println("Import.java - starting main method");
		DBConnect dbc = new DBConnect();
		
		//TODO 
		// Below are two options (a and b) to access your MySQL database. 
		// Comment out the option you DO NOT want then fill in the appropriate values in the method
		// a) Use the option below if you are accessing MySQL on your local machine
		// dbc.setUpForLocalMySQL("myUsername", "myPassword", "myDatabaseName"); //TODO EDIT THIS LINE
		// b) Use the option below if you are accessing MySQL over an SSH connection
		dbc.setUpForKnuthMySQL("s2992196", "iestadom", "s2992196", "s2992196", "iestadom"); //TODO OR EDIT THIS LINE
		
		
		try {
			Connection conn = dbc.openConnection();

			System.out.println("\nBegining to import procedures");
			ScriptRunner runner = new ScriptRunner(conn, false, true);	// set up a new ScriptRunner
			runner.setLogWriter(null);									// set its log to null
			// relative address of the write the specified script to the database
			String scriptRelativeAddress = "./data/procedures.sql";

			System.out.println("Project working directory = " + System.getProperty("user.dir"));
			System.out.println("Procedures script file location = " + System.getProperty("user.dir")+scriptRelativeAddress.substring(1, scriptRelativeAddress.length()));
			System.out.println("Procedures successfully imported");

			runner.runScript(new BufferedReader(new FileReader(scriptRelativeAddress))); 
			dbc.closeConnection(); // close the connection with the database
		} 
		catch (FileNotFoundException e) {
			System.err.println("Unable to find the data file.");
			e.printStackTrace();
		} 
		catch (IOException e) {
			System.err.println("An error has occured");
			e.printStackTrace();
		} 
		catch (SQLException e) {
			System.err.println("An SQL error has occured");
			e.printStackTrace();
		}
		System.out.println("Import.java - ending main method");

	}
}
