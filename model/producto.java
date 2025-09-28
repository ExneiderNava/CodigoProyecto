package com.example.proyecto_ebenezer.model;

public class producto {

    private int id;
    private String nombre;
    private String tipo;
    private int precio;
    private int stock;


    public producto(int id, String nombre, String tipo, int precio, int stock) {
        this.id = id;
        this.nombre = nombre;
        this.tipo = tipo;
        this.precio = precio;
        this.stock = stock;
    }

    public boolean hayStock(int cantidad){
        return this.stock >=cantidad;

    }

    public void descontarStock(int cantidad){
        if(hayStock(cantidad)){
            this.stock-=cantidad;
        }
    }

    public int calcularTotal(int cantidad){
        return cantidad * precio;

    }

    public int getId(){
        return id;
    }

    public String getNombre(){
        return nombre;
    }

    public int getPrecio(){
        return precio;
    }

    public int getStock(){
        return stock;
    }

    public String getTipo(){
        return tipo;
    }
}
