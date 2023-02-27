import java.sql.*;
import java.io.*;

public class Purchaser {
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
			String csvFile = "purchaser.csv";

			// INSERT DATASETS INTO TABLE purchaser
			try {
				con.setAutoCommit(false);

				String insertSql = "INSERT INTO Purchaser(first_name, last_name, email_address) VALUES(?, ?, ?)";

				PreparedStatement prepStmt = con.prepareStatement(insertSql);

				BufferedReader reader = new BufferedReader(new FileReader(csvFile));
				String column = null;

				reader.readLine();
				while((column = reader.readLine()) != null) {
					String[] storedData = column.split(",");

					String first_name = storedData[0];
					String last_name = storedData[1];
					String email = storedData[2];

					prepStmt.setString(1, first_name);
					prepStmt.setString(2, last_name);
					prepStmt.setString(3, email);
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
			// Check number of datasets in purchaser table
			ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Purchaser");
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
