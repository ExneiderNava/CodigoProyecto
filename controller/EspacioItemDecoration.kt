package com.example.proyecto_ebenezer.controller

import android.graphics.Rect
import android.view.View
import androidx.recyclerview.widget.RecyclerView

class EspacioItemDecoration(private  val espacio : Int) : RecyclerView.ItemDecoration() {
    override fun getItemOffsets(
        outRect: Rect,
        view: View,
        parent: RecyclerView,
        state: RecyclerView.State
    ) {
        outRect.set(espacio, espacio, espacio, espacio)
    }
}