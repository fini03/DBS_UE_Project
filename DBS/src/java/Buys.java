import java.sql.*;
import java.util.Collections;
import java.util.Random;
import java.io.*;

public class Buys {
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
			String csvFile = "buys.csv";

			// INSERT DATASETS INTO TABLE buys
			try {
				con.setAutoCommit(false);

				String insertSql = "INSERT INTO Buys(purchaser_id, item_id, payment_method, license, purchase_date) VALUES(?, ?, ?, ?, ?)";

				PreparedStatement prepStmt = con.prepareStatement(insertSql);
				
				BufferedReader reader = new BufferedReader(new FileReader(csvFile));
				String column = null;

				int counter = 1000;
				reader.readLine();
				while(counter != 0) {
					column = reader.readLine();
					String[] storedData = column.split(",");
					
					Random randomId = new Random();
					int id = randomId.nextInt(1000 - 1) + 1;

					Random randomId2 = new Random();
					int id2 = randomId2.nextInt(1000 - 1) + 1;
					
					String payment_method = storedData[0];
					String license = storedData[1];
					String purchase_date = storedData[2];

					prepStmt.setInt(1, id);
					prepStmt.setInt(2, id2);
					prepStmt.setString(3, payment_method);
					prepStmt.setString(4, license);
					prepStmt.setDate(5, Date.valueOf(purchase_date));
					prepStmt.addBatch();
					
					--counter;
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
			// Check number of datasets in buys table
			ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Buys");
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
