import java.sql.*;
import java.io.*;

public class Employee {
	public static void main(String args[]) {
		try {
			// Loads the class "oracle.jdbc.driver.OracleDriver" into the memory
			Class.forName("oracle.jdbc.driver.OracleDriver");

			// Connection details
			String database = "jdbc:oracle:thin:@oracle19.cs.univie.ac.at:1521:orclcdb";
			String user = "";
			String pass = "";

			// Establish a connection to the database
			Connection con = DriverManager.getConnection(database, user, pass);
			Statement stmt = con.createStatement();

			System.out.println("Connection successful");

			// read csv file
			String csvFile = "employee.csv";
			String csvSupervisor = "supervisor_id.csv";

			// INSERT DATASETS INTO TABLE employee
			try {
				con.setAutoCommit(false);

				String insertSql = "INSERT INTO Employee(first_name, last_name, email_address, phone_number) VALUES(?, ?, ?, ?)";
				String insertSql2 = "INSERT INTO Employee(first_name, last_name, email_address, phone_number, supervisor_id) VALUES(?, ?, ?, ?, ?)";

				PreparedStatement prepStmt = con.prepareStatement(insertSql);
				PreparedStatement prepStmt2 = con.prepareStatement(insertSql2);

				BufferedReader reader = new BufferedReader(new FileReader(csvFile));
				BufferedReader reader2 = new BufferedReader(new FileReader(csvSupervisor));
				String column = null;
				String column2 = null;
				int help = 50;
				
				reader.readLine();
				reader2.readLine();
				while(help != 0) {
					column = reader.readLine();
					String[] storedData = column.split(",");

					String first_name = storedData[0];
					String last_name = storedData[1];
					String email = storedData[2];
					String phone_number = storedData[3];
				
					prepStmt.setString(1, first_name);
					prepStmt.setString(2, last_name);
					prepStmt.setString(3, email);
					prepStmt.setString(4, phone_number);
					prepStmt.addBatch();
					
					--help;
				}
				while((column = reader.readLine()) != null) {
					column2 = reader2.readLine();
					String[] storedData = column.split(",");
					String[] storedData2 = column2.split(",");

					String first_name = storedData[0];
					String last_name = storedData[1];
					String email = storedData[2];
					String phone_number = storedData[3];
					String supervisor_id = storedData2[0];
				
					prepStmt2.setString(1, first_name);
					prepStmt2.setString(2, last_name);
					prepStmt2.setString(3, email);
					prepStmt2.setString(4, phone_number);
					prepStmt2.setString(5, supervisor_id);
					prepStmt2.addBatch();
				}
				reader.close();
				reader2.close();
				int[] insert = null;
				int[] insert2 = null;

				try {
					insert = prepStmt.executeBatch();
					System.out.println("Batch successful");
					con.commit();
				} catch (BatchUpdateException buexp) {
					System.out.println("Error message: " + buexp.getMessage());
					con.rollback();
				}
				prepStmt.close();
				try {
					insert2 = prepStmt2.executeBatch();
					System.out.println("Batch successful.");
					con.commit();
				} catch (BatchUpdateException buexp) {
					System.out.println("Error message: " + buexp.getMessage());
					con.rollback();
				}
				prepStmt2.close();
			} catch (Exception exp) {
				System.out.println("Error message: " + exp.getMessage());
			} finally {
				try {
					con.setAutoCommit(true);
				} catch (SQLException exc) {
					exc.printStackTrace();
				}
			}
			// Check number of datasets in employee table
			ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Employee");
			if(rs.next()) {
				int count = rs.getInt(1);
				System.out.println("Number of datasets: " + count);
			} 

			// Clean up connections
			rs.close();
			stmt.close();
			con.close(); 
		} catch (Exception exp) {
			System.err.println(exp.toString()); 
		}
	}
}
