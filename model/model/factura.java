package com.example.proyecto_ebenezer.model;

public class factura {

    private int ventaId;
    private producto producto;
    private int cantidad;
    private double montoTotal;


    public int calcularMontoTotal(producto producto, int cantidad) {
        return producto.getPrecio() * cantidad;

    }
}
