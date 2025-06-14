
package Model;


public class Producto {
    private int id;
    private String nombre;
    private int precio;
    private int stock;

    public Producto(int id, String nombre, int precio, int stock) {
        this.id = id;
        this.nombre = nombre;
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
    
    public String getNombre(){
        return nombre;
    }
    
    public int getPrecio(){
        return precio;
    }
    
    
    
    
}
