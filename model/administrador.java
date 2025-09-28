package com.example.proyecto_ebenezer.model;

public class administrador {

    private int id;
    private String nombre;
    private String apellido;
    private String correo;
    private int celular;
    private Object foto;
    private String fechaVigenciaContrato;

    public administrador(int id, String nombre, String apellido, String correo, int celular, byte[] foto, String fechaVigenciaContrato) {
        this.id = id;
        this.nombre = nombre;
        this.apellido = apellido;
        this.correo = correo;
        this.celular = celular;
        this.foto = foto;
        this.fechaVigenciaContrato = fechaVigenciaContrato;
    }

    public String getNombreCompleto() {
        return nombre + " " + apellido;


    }
}
