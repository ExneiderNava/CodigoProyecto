
package Model;


public class Factura {
    private int ventaId;
    private Producto producto;
    private int cantidad;
    private double montoTotal;
    
    
    public int calcularMontoTotal(Producto producto, int cantidad) {
    return producto.getPrecio() * cantidad;
    
}

}

