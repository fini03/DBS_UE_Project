import java.sql.*;
import java.util.Random;
import java.io.*;

public class Creator {
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
			String csvUsernames = "usernames.csv";
			String csvCreator = "creator.csv";

			// INSERT DATASETS INTO TABLE creator
			try {
				con.setAutoCommit(false);

				String insertSql = "INSERT INTO Creator(purchaser_id, content, username, start_date) VALUES(?, ?, ?, ?)";

				PreparedStatement prepStmt = con.prepareStatement(insertSql);
				ResultSet purchaser_id = stmt.executeQuery("SELECT purchaser_id FROM Purchaser");

				BufferedReader reader = new BufferedReader(new FileReader(csvUsernames));
				BufferedReader reader2 = new BufferedReader(new FileReader(csvCreator));
				String column = null;
				String column2 = null;

				reader.readLine();
				reader2.readLine();
				while(purchaser_id.next()) {
					column = reader.readLine();
					column2 = reader2.readLine();
					String[] storedData = column.split(",");
					String[] storedData2 = column2.split(",");
					
					Random randomId = new Random();
					int id = randomId.nextInt(1000 - 1) + 1;

					String username = storedData[0];
					String content = storedData2[0];
					String start_date = storedData2[1];

					prepStmt.setInt(1, purchaser_id.getInt(1));
					prepStmt.setString(2, content);
					prepStmt.setString(3, username);
					prepStmt.setDate(4, Date.valueOf(start_date));
					prepStmt.addBatch();
					
				}
				reader.close();
				reader2.close();
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
			// Check number of datasets in creator table
			ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Creator");
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
