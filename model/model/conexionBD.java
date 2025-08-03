package com.example.proyecto_ebenezer.model;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;


public class conexionBD {

    private static final String URL = "jdbc:mysql://localhost:3306/proyecto_formativo_cafebenezer";
    private static final String USER = "root";
    private static final String PASSWORD = ""; // En XAMPP por defecto no tiene contraseña

    public static Connection conectar() throws SQLException {
        return DriverManager.getConnection(URL, USER, PASSWORD);
    }
}
