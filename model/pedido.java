package com.example.proyecto_ebenezer.model;
import java.util.*;
public class pedido {

    private int id;
    private cliente cliente;
    private empleado empleado;
    private profesor profesor;
    private Date fecha;
    private Map<producto, Integer> productos = new HashMap<>();

    public pedido(int id, cliente cliente, empleado empleado, profesor profesor, Date fecha) {
        this.id = id;
        this.cliente = cliente;
        this.empleado = empleado;
        this.profesor = profesor;
        this.fecha = fecha;
    }

    public void agregarProducto (producto producto, int cantidad){
        if (producto.hayStock(cantidad)){
            productos.put(producto,cantidad);
            producto.descontarStock(cantidad);
        }
        else {
            System.out.println("No hay suficiente Stock para: " + producto.getNombre());
        }
    }

    public int calcularTotal(){
        int total=0;
        for(Map.Entry<producto, Integer> entry : productos.entrySet()){
            producto producto = entry.getKey();
            int cantidad = entry.getValue();
            total += producto.calcularTotal(cantidad);
        }
        return total;
    }

    public cliente getCliente(){
        return cliente;

    }

    public Map<producto, Integer> getProductos(){
        return productos;
    }
}
