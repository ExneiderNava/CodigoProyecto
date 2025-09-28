package com.example.proyecto_ebenezer.view

import android.content.Intent
import android.graphics.BitmapFactory
import android.graphics.drawable.ColorDrawable
import android.os.Bundle
import android.util.TypedValue
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.GridLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.android.volley.toolbox.JsonArrayRequest
import com.android.volley.toolbox.Volley
import com.example.proyecto_ebenezer.controller.ProductoAdapter
import com.example.proyecto_ebenezer.R
import com.example.proyecto_ebenezer.controller.EspacioItemDecoration
import com.example.proyecto_ebenezer.model.getproductos_prueba
import android.util.Base64
import android.util.Log
import android.view.Gravity
import android.view.LayoutInflater
import android.view.WindowManager
import android.widget.Button
import android.widget.FrameLayout
import android.widget.ImageView
import android.widget.LinearLayout
import android.widget.PopupWindow
import android.widget.TextView
import com.example.proyecto_ebenezer.model.carrito_item
import java.text.NumberFormat
import java.util.Locale
import android.graphics.Color
import com.android.volley.toolbox.StringRequest
import com.google.gson.Gson
import android.widget.ImageButton

class InterfazClienteActivity : AppCompatActivity() {

    //variables utiles para la actualización
    private val listaVisible = mutableListOf<getproductos_prueba>()
    private val categorias = linkedSetOf<String>()

    private lateinit var recyclerView: RecyclerView
    private lateinit var adapter: ProductoAdapter
    private val listaProductos = mutableListOf<getproductos_prueba>()
    private val carrito = HashMap<String, carrito_item>()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.interfaz_cliente)

        val btncancelar = findViewById<Button>(R.id.btn_cancelar)
        btncancelar.setOnClickListener {
            cancelarysalir()
        }

        recyclerView = findViewById(R.id.recycler_productos)
        recyclerView.layoutManager = GridLayoutManager(this, 2, RecyclerView.HORIZONTAL, false)



        //para implementar la actualización se debera cambiar este adapter
        // en la parte donde se usa listaProductos cambiar por listaVisible
        adapter = ProductoAdapter(this, listaVisible, object : ProductoAdapter.onCantidadChangeListener {
            override fun onCantidadChange(producto: getproductos_prueba, nuevaCantidad: Int) {
                if (nuevaCantidad > 0) {
                    carrito[producto.id] =
                        carrito_item(producto.id, producto.nombre, producto.precio, nuevaCantidad)

                } else {
                    carrito.remove(producto.id)
                }
            }
        })


        recyclerView.adapter = adapter

        val espacioEnDp = 6
        val espacioEnPx = TypedValue.applyDimension(
            TypedValue.COMPLEX_UNIT_DIP,
            espacioEnDp.toFloat(),
            resources.displayMetrics
        ).toInt()
        recyclerView.addItemDecoration(EspacioItemDecoration(espacioEnPx))

        val btnCarrito = findViewById<ImageView>(R.id.carrito_compras)
        btnCarrito.setOnClickListener {
            mostrarVentanaCarrito()
        }
        cargarProductos()

        val btnComprar = findViewById<Button>(R.id.btn_comprar)
        btnComprar.setOnClickListener {
            if (carrito.isNotEmpty()) {
                mostrarVentanaPago()
            } else {
                Toast.makeText(this, "Debe tener productos en el carrito", Toast.LENGTH_SHORT).show()
            }

        }

        val btnSnacks = findViewById<ImageButton>(R.id.cat_snacks)
        btnSnacks.setOnClickListener {
            filtrarPorCategoria("1")
        }

        val comidas = findViewById<ImageButton>(R.id.cat_comidas)
        comidas.setOnClickListener {
            filtrarPorCategoria("3")
        }

        val bebidas = findViewById<ImageButton>(R.id.cat_bebidas)
        bebidas.setOnClickListener {
            filtrarPorCategoria("2")
        }

        val postres = findViewById<ImageButton>(R.id.cat_postres)
        postres.setOnClickListener {
            filtrarPorCategoria("4")
        }

        val otros = findViewById<ImageButton>(R.id.cat_otros)
        otros.setOnClickListener {
            filtrarPorCategoria("5")
        }


    }

    private fun cargarProductos(){
        val url = "http://10.0.2.2/proyecto_F2/sacar_productos/get_productos.php"

        val request = JsonArrayRequest(url,
            {response ->
                listaProductos.clear()
                listaVisible.clear()
                categorias.clear()

                for (i in 0 until response.length()){
                    val item = response.getJSONObject(i)

                    val id = item.getString("Id_Producto")
                    val nombre = item.getString("Nombre_Producto")
                    val precio = item.getDouble("Precio_venta")
                    val imagenBase64 = item.getString("Foto")
                    val stock = item.getInt("Cantidad_en_Stock")
                    val Tipo_Producto = item.getString("Tipo_Producto")

                    val imagenBytes = Base64.decode(imagenBase64, Base64.DEFAULT)
                    val bitmap = BitmapFactory.decodeByteArray(imagenBytes, 0, imagenBytes.size)

                    if(bitmap != null){
                        val producto = getproductos_prueba(id, nombre, precio, imagen = bitmap, stock, cantidad = 0, Tipo_Producto)
                        listaProductos.add(producto)
                        listaVisible.add(producto)
                        categorias.add(Tipo_Producto)

                    } else {
                        Log.e("ErrorImagen", "No se pudo decodificar la imagen: $nombre")
                    }



                }
                adapter.notifyDataSetChanged()
            }, { error ->
                Toast.makeText(this, "Error: ${error.message}", Toast.LENGTH_LONG).show()
            }
        )

        Volley.newRequestQueue(this).add(request)
    }

    private fun mostrarVentanaCarrito() {
        val inflater = layoutInflater
        val popupView = inflater.inflate(R.layout.carrito, null)

        val fondoOscuro = FrameLayout(this).apply {
            layoutParams = FrameLayout.LayoutParams(
                FrameLayout.LayoutParams.MATCH_PARENT,
                FrameLayout.LayoutParams.MATCH_PARENT
            )
            setBackgroundColor(0x88000000.toInt())
            isClickable = true
        }

        val layoutParams = FrameLayout.LayoutParams(
            (resources.displayMetrics.widthPixels * 0.7).toInt(),
            FrameLayout.LayoutParams.WRAP_CONTENT
        )
        layoutParams.gravity = Gravity.CENTER
        fondoOscuro.addView(popupView, layoutParams)

        val rootView = window.decorView.findViewById<FrameLayout>(android.R.id.content)
        rootView.addView(fondoOscuro)

        fondoOscuro.setOnClickListener {
            rootView.removeView(fondoOscuro)

        }

        popupView.setOnClickListener {

        }

        val contenedor = popupView.findViewById<LinearLayout>(R.id.contenedor_productos_carrito)
        contenedor.removeAllViews()

        for ((_, item) in carrito) {
            val productoview = inflater.inflate(R.layout.item_carrito, contenedor, false)

            val nombretxt = productoview.findViewById<TextView>(R.id.txt_nombre_carrito)
            val cantidadtxt = productoview.findViewById<TextView>(R.id.txt_cantidad_carrito)
            val preciotxt = productoview.findViewById<TextView>(R.id.txt_precio_carrito)

            nombretxt.text = item.nombre
            cantidadtxt.text = "Cantidad: ${item.cantidad}"
            preciotxt.text = "Total: $${item.precio * item.cantidad}"

            contenedor.addView(productoview)


        }

        val totalGeneraltxt = popupView.findViewById<TextView>(R.id.total_carrito)
        val totalGeneral = carrito.values.sumOf { it.precio * it.cantidad }

        val formato = NumberFormat.getNumberInstance(Locale("es","CO"))
        val totalformato = formato.format(totalGeneral.toInt())

        totalGeneraltxt.text = "Total a pagar: $ $totalformato"




    }

    private fun cancelarysalir() {
        carrito.clear()

        val prefs = getSharedPreferences("usuario", MODE_PRIVATE)
        prefs.edit().clear().apply()

        val intent = Intent(this, MainActivity::class.java)
        intent.flags = Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TASK
        startActivity(intent)
    }

    private fun mostrarVentanaPago(){
        val inflater = LayoutInflater.from(this)
        val popupView = inflater.inflate(R.layout.venta_metodo_pago, null)

        val fondoOsuro = FrameLayout(this).apply {
            layoutParams = FrameLayout.LayoutParams(
                FrameLayout.LayoutParams.MATCH_PARENT,
                FrameLayout.LayoutParams.MATCH_PARENT
            )
            setBackgroundColor(0x88000000.toInt())
            isClickable = true
        }

        val layoutParams = FrameLayout.LayoutParams(
            (resources.displayMetrics.widthPixels * 0.7).toInt(),
            FrameLayout.LayoutParams.WRAP_CONTENT
        )

        layoutParams.gravity = Gravity.CENTER
        fondoOsuro.addView(popupView, layoutParams)

        val rootView = window.decorView.findViewById<FrameLayout>(android.R.id.content)
        rootView.addView(fondoOsuro)

        fondoOsuro.setOnClickListener {
            rootView.removeView(fondoOsuro)
        }

        popupView.setOnClickListener {

        }


        val opcionEfectivo = popupView.findViewById<LinearLayout>(R.id.opcion_efectivo)
        val opcionDigital = popupView.findViewById<LinearLayout>(R.id.opcion_digital)

        opcionEfectivo.setOnClickListener {
            rootView.removeView(fondoOsuro)
            mostrarConfirmacion("efectivo")
        }

        opcionDigital.setOnClickListener {
            rootView.removeView(fondoOsuro)
            mostrarVentanaPagoDigital()
        }


    }

    private fun mostrarConfirmacion(metodoPago: String) {

        val inflater = LayoutInflater.from(this)
        val view = inflater.inflate(R.layout.confirmacion_pago, null)

        val popup = PopupWindow(
            view,
            WindowManager.LayoutParams.WRAP_CONTENT,
            WindowManager.LayoutParams.WRAP_CONTENT,
            true
        )

        popup.setBackgroundDrawable(ColorDrawable(Color.TRANSPARENT))
        popup.isOutsideTouchable = false
        popup.showAtLocation(findViewById(android.R.id.content), Gravity.CENTER, 0, 0)


        val testPrefs = getSharedPreferences("datos_usuario", MODE_PRIVATE)
        Log.d("DEBUG_PREFS", "ID USUARIO = ${testPrefs.getString("id_usuario", "VACÍO")}")

        enviarPedidoDB(metodoPago)

        view.postDelayed({
            popup.dismiss()

            val prefs = getSharedPreferences("usuario", MODE_PRIVATE)
            prefs.edit().clear().apply()

            val intent = Intent(this, MainActivity::class.java)
            intent.flags = Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TASK
            startActivity(intent)
        }, 2000)

    }



    private fun mostrarVentanaPagoDigital(){
        val infalter = LayoutInflater.from(this)
        val view = infalter.inflate(R.layout.metodo_digital, null)

        val fondoOsuro = FrameLayout(this).apply {
            layoutParams = FrameLayout.LayoutParams(
                FrameLayout.LayoutParams.MATCH_PARENT,
                FrameLayout.LayoutParams.MATCH_PARENT
            )
            setBackgroundColor(0x88000000.toInt())
            isClickable = true
        }

        val layoutParams = FrameLayout.LayoutParams(
            (resources.displayMetrics.widthPixels * 0.7).toInt(),
            FrameLayout.LayoutParams.WRAP_CONTENT
        )
        layoutParams.gravity = Gravity.CENTER
        fondoOsuro.addView(view, layoutParams)

        val rootView = window.decorView.findViewById<FrameLayout>(android.R.id.content)
        rootView.addView(fondoOsuro)

        fondoOsuro.setOnClickListener {
            rootView.removeView(fondoOsuro)
        }

        view.setOnClickListener {

        }

        val btnListo = view.findViewById<Button>(R.id.btn_confirmar_pago_digital)
        btnListo.setOnClickListener {
            rootView.removeView(fondoOsuro)
            mostrarConfirmacion("digital")
        }


    }

    private fun enviarPedidoDB(metodoPago: String){
        val url = "http://10.0.2.2/proyecto_F2/ingresar_ventas/realizar_pedido.php"

        val carritoArray = carrito.values.map {
            mapOf(
            "id" to it.id,
            "nombre" to it.nombre,
            "precio" to it.precio,
            "cantidad" to it.cantidad
            )
        }

        val sharedPref = getSharedPreferences("datos_usuario", MODE_PRIVATE)
        val idUsuario = sharedPref.getString("id_usuario", "")

        if(idUsuario.isNullOrBlank()){
            Toast.makeText(this, "no se encontro el id de usuario", Toast.LENGTH_LONG).show()
            return
        }

        val parametros = object : StringRequest(Method.POST, url,
            { response ->
                Log.d("PEDIDO", "Respuesta: $response")
                Toast.makeText(this, "Pedido enviado con exito", Toast.LENGTH_LONG).show()

                carrito.clear()
                adapter.notifyDataSetChanged()
            },
            { error ->
                Log.e("PEDIDO", "Error: ${error.message}")
                Toast.makeText(this, "Error al enviar el pedido", Toast.LENGTH_LONG).show()
            }
        ) {
            override fun getParams(): MutableMap<String, String> {
                val params = HashMap<String, String>()
                params["metodo_pago"] = metodoPago
                params["carrito"] = Gson().toJson(carritoArray)
                params["id_usuario"] = idUsuario!!
                return params
            }
        }
        Volley.newRequestQueue(this).add(parametros)
    }

    //funcion para usarla en el xml

    private fun filtrarPorCategoria(tipo: String?){
        listaVisible.clear()
        if(tipo.isNullOrEmpty() || tipo.equals("TODO", ignoreCase = true)){
            listaVisible.addAll(listaProductos)
        } else {
            listaVisible.addAll(listaProductos.filter { it.Tipo_Producto == tipo })
        }
        adapter.notifyDataSetChanged()
    }

}
