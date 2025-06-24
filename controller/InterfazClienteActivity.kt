package com.example.proyecto_ebenezer.controller

import android.content.Context
import android.view.LayoutInflater
import android.widget.Button
import android.widget.ImageView
import android.widget.LinearLayout
import android.widget.TextView
import com.example.proyecto_ebenezer.R
import com.example.proyecto_ebenezer.model.getproductos_prueba

private fun mostrarProductos(
    productos: List<getproductos_prueba>,
    context: Context,
    contenedor: LinearLayout
) {
    for (producto in productos) {
        val vistaProducto = LayoutInflater.from(context).inflate(R.layout.item_producto, contenedor, false)

        val img = vistaProducto.findViewById<ImageView>(R.id.img_producto)
        val nombre = vistaProducto.findViewById<TextView>(R.id.tx_nombre_producto)
        val precio = vistaProducto.findViewById<TextView>(R.id.txt_precio)
        val cantidad = vistaProducto.findViewById<TextView>(R.id.txt_cantidad)
        val btnMenos = vistaProducto.findViewById<Button>(R.id.btn_menos)
        val btnMas = vistaProducto.findViewById<Button>(R.id.btn_mas)

        var cantidadActual = producto.cantidad

        img.setImageResource(producto.imagen)
        nombre.text = producto.nombre
        precio.text = "$${producto.precio}"
        cantidad.text = cantidadActual.toString()

        btnMas.setOnClickListener {
            cantidadActual++
            cantidad.text = cantidadActual.toString()
        }

        btnMenos.setOnClickListener {
            if (cantidadActual > 0) {
                cantidadActual--
                cantidad.text = cantidadActual.toString()
            }
        }

        contenedor.addView(vistaProducto)
    }
}