package com.example.proyecto_ebenezer.model;
import java.util.*;
public class venta {

    private int id;
    private pedido pedido ;
    private administrador admin;
    private Date fecha;

    public venta(int id, pedido pedido, administrador admin) {
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
        for (Map.Entry<producto, Integer> entry : pedido.getProductos().entrySet()) {
            producto p = entry.getKey();
            int cantidad = entry.getValue();
            System.out.println(p.getNombre() + " x" + cantidad + " = $" + p.calcularTotal(cantidad));
        }
        System.out.println("Total a pagar: $" + pedido.calcularTotal());
        System.out.println("Atendido por: " + admin.getNombreCompleto());
        System.out.println("====================\n");
    }
}
