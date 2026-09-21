package util;

import java.sql.Connection;

import java.sql.DriverManager;

public class DBConnection {

private static final String URL =

"jdbc:mysql://localhost:3306/online_shopping"

+ "?useSSL=false"

+ "&allowPublicKeyRetrieval=true"

+ "&serverTimezone=UTC";

private static final String USER = "root";

private static final String PASSWORD = "Hema003*";

public static Connection getConnection() {

Connection connection = null;

try {

Class.forName("com.mysql.cj.jdbc.Driver");

connection = DriverManager.getConnection(

URL,

USER,

PASSWORD );

System.out.println("Database Connected");

} catch (Exception e) {

System.out.println("Database Connection Failed");

e.printStackTrace();}

return connection;}}