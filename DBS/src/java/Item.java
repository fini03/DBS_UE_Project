import java.sql.*;
import java.util.Random;
import java.io.*;

public class Item {
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
			String csvFile = "item.csv";

			// INSERT DATASETS INTO TABLE item
			try {
				con.setAutoCommit(false);

				String insertSql = "INSERT INTO Item(price, max_uploadsize, upload_date, creator_id, employee_id) VALUES(?, ?, ?, ?, ?)";

				PreparedStatement prepStmt = con.prepareStatement(insertSql);
				ResultSet employee_id = stmt.executeQuery("SELECT employee_id FROM Employee");

				BufferedReader reader = new BufferedReader(new FileReader(csvFile));
				String column = null;

				reader.readLine();
				while(employee_id.next()) {
					column = reader.readLine();
					String[] storedData = column.split(",");
					
					Random randomId = new Random();
					int id = randomId.nextInt(1000 - 1) + 1;

					String price = storedData[0];
					String upload_date = storedData[1];

					prepStmt.setString(1, price);
					prepStmt.setInt(2, 100);
					prepStmt.setDate(3, Date.valueOf(upload_date));
					prepStmt.setInt(4, id);
					prepStmt.setInt(5, employee_id.getInt(1));
					prepStmt.addBatch();

					
				}
				reader.close();
				int[] insert = null;

				try {
					insert = prepStmt.executeBatch();
					System.out.println("Batch successful");
					con.commit();
				} catch (BatchUpdateException buexp) {
					System.out.println("Error message: " + buexp.getMessage());
					con.rollback();
				}
				prepStmt.close();
			} catch (Exception exp) {
				System.out.println("Error message: " + exp.getMessage());
			} finally {
				try {
					con.setAutoCommit(true);
				} catch (SQLException exc) {
					exc.printStackTrace();
				}
			}
			// Check number of datasets in item table
			ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Item");
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
