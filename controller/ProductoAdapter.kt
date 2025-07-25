package com.example.proyecto_ebenezer.controller

import android.content.Context
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.proyecto_ebenezer.R
import com.example.proyecto_ebenezer.model.getproductos_prueba

class ProductoAdapter(
    private val context: Context,
    private val listaProductos: List<getproductos_prueba>
) : RecyclerView.Adapter<ProductoAdapter.ProductoViewHolder>(){

    class ProductoViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val imagen: ImageView = view.findViewById(R.id.img_producto)
        val nombre: TextView = view.findViewById(R.id.tx_nombre_producto)
        val precio: TextView = view.findViewById(R.id.txt_precio)
        val cantidad: TextView = view.findViewById(R.id.txt_cantidad)
        val btnMas: Button = view.findViewById(R.id.btn_mas)
        val btnMenos: Button = view.findViewById(R.id.btn_menos)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ProductoViewHolder {
        val vista = LayoutInflater.from(context).inflate(R.layout.item_producto, parent, false)
        return ProductoViewHolder(vista)
    }

    override fun onBindViewHolder(holder: ProductoViewHolder, position: Int) {
        val producto = listaProductos[position]
        var cantidadActual = producto.cantidad

        holder.imagen.setImageResource(producto.imagen)
        holder.nombre.text = producto.nombre
        holder.precio.text = "$${producto.precio}"
        holder.cantidad.text = cantidadActual.toString()


        holder.btnMas.setOnClickListener {
            cantidadActual++
            holder.cantidad.text = cantidadActual.toString()
        }


        holder.btnMenos.setOnClickListener {
            if (cantidadActual > 0) {
                cantidadActual--
                holder.cantidad.text = cantidadActual.toString()
            }
        }
    }

    override fun getItemCount(): Int {
        return listaProductos.size
    }
    }
