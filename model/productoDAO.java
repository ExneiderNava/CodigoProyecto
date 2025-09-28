package com.example.proyecto_ebenezer.model;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;


public class productoDAO {

    public void guardarProducto(producto p) {
        try (Connection conn = conexionBD.conectar()) {
            String sql = "INSERT INTO productos (Id_Producto, Nombre_Producto, Tipo_Producto, Precio, Cantidad_en_Stock) VALUES (?, ?, ?, ?,?)";
            PreparedStatement stmt = conn.prepareStatement(sql);
            stmt.setInt(1, p.getId());
            stmt.setString(2, p.getNombre());
            stmt.setString (3, p.getTipo());
            stmt.setInt(4, p.getPrecio());
            stmt.setInt(5, p.getStock());
            stmt.executeUpdate();
            System.out.println("✅ Producto guardado en la base de datos.");
        } catch (SQLException e) {
            System.out.println("❌ Error al guardar producto: " + e.getMessage());
        }
    }

    // Método para obtener todos los productos de la base de datos
    public List<producto> listarProductos() {
        List<producto> productos = new ArrayList<>();
        try (Connection conn = conexionBD.conectar()) {
            String sql = "SELECT * FROM productos";
            Statement stmt = conn.createStatement();
            ResultSet rs = stmt.executeQuery(sql);
            while (rs.next()) {
                producto p = new producto(
                        rs.getInt("Id_Producto"),
                        rs.getString("Nombre_Producto"),
                        rs.getString ("Tipo_Producto"),
                        rs.getInt("Precio"),
                        rs.getInt("Cantidad_en_Stock")
                );
                productos.add(p);
            }
        } catch (SQLException e) {
            System.out.println("❌ Error al listar productos: " + e.getMessage());
        }
        return productos;
    }

    // Método para actualizar el stock de un producto
    public void actualizarStock(int id, int nuevoStock) {
        try (Connection conn = conexionBD.conectar()) {
            String sql = "UPDATE productos SET stock = ? WHERE Id_Producto = ?";
            PreparedStatement stmt = conn.prepareStatement(sql);
            stmt.setInt(1, nuevoStock);
            stmt.setInt(2, id);
            int filas = stmt.executeUpdate();
            if (filas > 0) {
                System.out.println("✅ Stock actualizado correctamente.");
            } else {
                System.out.println("⚠️ No se encontró el producto con ID: " + id);
            }
        } catch (SQLException e) {
            System.out.println("❌ Error al actualizar stock: " + e.getMessage());
        }
    }

    // Método para eliminar un producto por ID
    public void eliminarProducto(int id) {
        try (Connection conn = conexionBD.conectar()) {
            String sql = "DELETE FROM productos WHERE Id_Producto = ?";
            PreparedStatement stmt = conn.prepareStatement(sql);
            stmt.setInt(1, id);
            int filas = stmt.executeUpdate();
            if (filas > 0) {
                System.out.println("✅ Producto eliminado correctamente.");
            } else {
                System.out.println("⚠️ No se encontró el producto con ID: " + id);
            }
        } catch (SQLException e) {
            System.out.println("❌ Error al eliminar producto: " + e.getMessage());
        }
    }
}
