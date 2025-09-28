package com.example.proyecto_ebenezer.model

class carrito_item (
    val id: String,
    val nombre: String,
    val precio: Double,
    val cantidad: Int
){
    fun obtenertotal(): Double{
        return precio * cantidad

    }
}