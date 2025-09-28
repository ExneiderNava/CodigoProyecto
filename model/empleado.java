package com.example.proyecto_ebenezer.model;

public class empleado {

    private int id;
    private String nombre;
    private String apellido;
    private String cargo;
    private String correo;
    private int telefono;
    private String estadoContrato;

    public empleado(int id, String nombre, String apellido, String cargo, String correo, int telefono, String estadoContrato) {
        this.id = id;
        this.nombre = nombre;
        this.apellido = apellido;
        this.cargo = cargo;
        this.correo = correo;
        this.telefono = telefono;
        this.estadoContrato = estadoContrato;
    }

    public String getNombreCompleto(){
        return nombre + " " + apellido;

    }
}
