package com.example.proyecto_ebenezer.model

import android.graphics.Bitmap


class getproductos_prueba(
    val id: String,
    val nombre: String,
    val precio: Double,
    val imagen: Bitmap,
    val stock: Int,
    val cantidad: Int = 0,
    val Tipo_Producto: String
)

