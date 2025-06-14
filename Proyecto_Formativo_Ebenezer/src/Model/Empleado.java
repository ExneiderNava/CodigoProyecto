
package Model;


public class Empleado {
    private int id;
    private String nombre;
    private String apellido;
    private String cargo;
    private String correo;
    private int telefono;
    private String estadoContrato;

    public Empleado(int id, String nombre, String apellido, String cargo, String correo, int telefono, String estadoContrato) {
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
