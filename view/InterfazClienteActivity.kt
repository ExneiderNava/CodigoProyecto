package com.example.proyecto_ebenezer.view

import android.os.Bundle
import android.util.TypedValue
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.GridLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.proyecto_ebenezer.controller.ProductoAdapter
import com.example.proyecto_ebenezer.R
import com.example.proyecto_ebenezer.controller.EspacioItemDecoration
import com.example.proyecto_ebenezer.model.getproductos_prueba

class InterfazClienteActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.interfaz_cliente)

        val productos = listOf(
            getproductos_prueba("Golpe Ranchero", 1000.0, R.drawable.golpe_ranchero),
            getproductos_prueba("Yupis Limón", 1200.0, R.drawable.rizadas_mayonesa),
            getproductos_prueba("Empanadas", 3800.0, R.drawable.tosti_empanada_limon),
            getproductos_prueba("Doritos", 3800.0, R.drawable.doritos)
        )

        val recyclerView = findViewById<RecyclerView>(R.id.recycler_productos)
        recyclerView.layoutManager = GridLayoutManager(this, 2, RecyclerView.HORIZONTAL, false)
        recyclerView.adapter = ProductoAdapter(this, productos)
        val espacioEnDP = 6
        val espacioPx = TypedValue.applyDimension(
            TypedValue.COMPLEX_UNIT_DIP,
            espacioEnDP.toFloat(),
            resources.displayMetrics
        ).toInt()
        recyclerView.addItemDecoration(EspacioItemDecoration(espacioPx))
    }
}