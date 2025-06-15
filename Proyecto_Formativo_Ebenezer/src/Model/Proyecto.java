
package Model;
import java.util.*;
import View.InicioDeSeccion;

public class Proyecto {

   
    public static void main(String[] args) {
        
        InicioDeSeccion view = new InicioDeSeccion();
        
        view.setVisible(true);
        
        
         // Crear productos
        /*Producto empanada = new Producto(1, "Empanada", 2500, 10);
        Producto jugo = new Producto(2, "Jugo", 2000, 5);

        // Crear cliente
        Cliente cliente = new Cliente(1001, "Laura", "Martinez", 16, "Vigente", 5, null, 311234567, "laura@gmail.com");

        // Crear administrador
        Administrador admin = new Administrador(1, "Carlos", "Gomez", "carlos@correo.com", 310000000, null, "2025-12-31");

        // Crear pedido
        Pedido pedido = new Pedido(5001, cliente, null, null, new Date());
        pedido.agregarProducto(empanada, 2);
        pedido.agregarProducto(jugo, 1);

        // Mostrar resumen del pedido
        System.out.println("Pedido creado para: " + cliente.getNombreCompleto());
        for (Map.Entry<Producto, Integer> entry : pedido.getProductos().entrySet()) {
            Producto prod = entry.getKey();
            int cantidad = entry.getValue();
            System.out.println(prod.getNombre() + " x" + cantidad + " = $" + prod.calcularTotal(cantidad));
        }
        System.out.println("Total del pedido: $" + pedido.calcularTotal());

        // Crear venta
        Venta venta = new Venta(5001, pedido, admin);
        venta.imprimirFactura();*/
    }
    
}


//crear formulario para ingresar los usuarios
//crear sistema de autenticación para los usuarios
