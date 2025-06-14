
package Model;

import java.util.*;


public class Venta {
    private int id;
    private Pedido pedido ;
    private Administrador admin;
    private Date fecha;

    public Venta(int id, Pedido pedido, Administrador admin) {
        this.id = id;
        this.pedido = pedido;
        this.admin = admin;
        this.fecha = new Date();
    }
    
    public void imprimirFactura() {
        System.out.println("\n===== FACTURA =====");
        System.out.println("Factura No. " + id);
        System.out.println("Cliente: " + pedido.getCliente().getNombreCompleto());
        System.out.println("Fecha: " + fecha);
        for (Map.Entry<Producto, Integer> entry : pedido.getProductos().entrySet()) {
            Producto p = entry.getKey();
            int cantidad = entry.getValue();
            System.out.println(p.getNombre() + " x" + cantidad + " = $" + p.calcularTotal(cantidad));
        }
        System.out.println("Total a pagar: $" + pedido.calcularTotal());
        System.out.println("Atendido por: " + admin.getNombreCompleto());
        System.out.println("====================\n");
    }
    
    
}
