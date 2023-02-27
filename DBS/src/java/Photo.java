import java.sql.*;
import java.util.Random;
import java.io.*;

public class Photo {
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
			String csvFile = "photo.csv";

			// INSERT DATASETS INTO TABLE photo
			try {
				con.setAutoCommit(false);

				String insertSql = "INSERT INTO Photo(photo_id, photo_dimension, name, camera_model) VALUES(?, ?, ?, ?)";

				PreparedStatement prepStmt = con.prepareStatement(insertSql);
				ResultSet item_id = stmt.executeQuery("SELECT item_id FROM Item");
				
				BufferedReader reader = new BufferedReader(new FileReader(csvFile));
				String column = null;

				reader.readLine();
				while(item_id.next()) {
					column = reader.readLine();
					String[] storedData = column.split(",");
					
					String photo_dimension = storedData[0];
					String photo_name = storedData[1];
					String camera_model = storedData[2];
					

					prepStmt.setInt(1, item_id.getInt(1));
					prepStmt.setString(2, photo_dimension);
					prepStmt.setString(3, photo_name);
					prepStmt.setString(4, camera_model);
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
			// Check number of datasets in photo table
			ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Photo");
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
