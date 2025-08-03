package com.example.proyecto_ebenezer.model;

public class cliente {

    private int id;
    private String nombre;
    private String apellido;
    private int edad;
    private String estadoMatricula;
    private int cursoId;
    private Object foto;
    private int celular;
    private String correo;

    public cliente(int id, String nombre, String apellido, int edad, String estadoMatricula, int cursoId, Object foto, int celular, String correo) {
        this.id = id;
        this.nombre = nombre;
        this.apellido = apellido;
        this.edad = edad;
        this.estadoMatricula = estadoMatricula;
        this.cursoId = cursoId;
        this.foto = foto;
        this.celular = celular;
        this.correo = correo;
    }

    public String getNombreCompleto(){
        return nombre + " " + apellido;
    }
}
