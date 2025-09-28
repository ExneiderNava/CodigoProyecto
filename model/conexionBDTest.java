package com.example.proyecto_ebenezer.model;
import java.sql.*;

public class conexionBDTest {

    public static void main(String[] args) {
        String url = "jdbc:mysql://localhost:3306/proyecto_formativo_cafebenezer"; // cambia por tu base de datos
        String usuario = "xampp";     // cambia si usas otro usuario
        String contraseña = "";

        try {
            Connection conn = DriverManager.getConnection(url, usuario, contraseña);
            System.out.println("✅ Conexión exitosa a MySQL");
            conn.close();
        } catch (SQLException e) {
            System.out.println("❌ Error de conexión: " + e.getMessage());
        }
    }

}
