
package Model;

import java.util.*;
public class Pedido {
    private int id;
    private Cliente cliente;
    private Empleado empleado;
    private Profesor profesor;
    private Date fecha;
    private Map<Producto, Integer> productos = new HashMap<>();

    public Pedido(int id, Cliente cliente, Empleado empleado, Profesor profesor, Date fecha) {
        this.id = id;
        this.cliente = cliente;
        this.empleado = empleado;
        this.profesor = profesor;
        this.fecha = fecha;
    }
    
    public void agregarProducto (Producto producto, int cantidad){
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
        for(Map.Entry<Producto, Integer> entry : productos.entrySet()){
            Producto producto = entry.getKey();
            int cantidad = entry.getValue();
            total += producto.calcularTotal(cantidad);
        }
        return total;
    }
    
    public Cliente getCliente(){
        return cliente;
        
    }
    
    public Map<Producto, Integer> getProductos(){
        return productos;
    }
    
}
