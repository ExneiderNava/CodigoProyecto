package com.example.proyecto_ebenezer.view

import android.content.Intent
import android.os.Bundle
import android.view.Gravity
import android.view.View
import android.widget.Button
import android.widget.LinearLayout
import android.widget.TableLayout
import android.widget.TableRow
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.cardview.widget.CardView
import android.graphics.Color
import android.net.Uri
import android.view.LayoutInflater
import android.widget.FrameLayout
import android.widget.ImageView
import android.widget.PopupWindow
import com.android.volley.Request
import com.android.volley.toolbox.JsonArrayRequest
import com.android.volley.toolbox.JsonObjectRequest
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.example.proyecto_ebenezer.R
import java.text.NumberFormat
import java.util.Locale

class AdministradorActivity : AppCompatActivity() {

    private lateinit var listaPedidosLayout: LinearLayout
    private lateinit var cardViewDetalle: CardView
    private lateinit var txtNombreCliente: TextView
    private lateinit var tablaDetalle: TableLayout
    private lateinit var totalPedido: TextView
    private lateinit var btnAprobar : Button
    private lateinit var btnCancelar : Button

    private var pedidoActualId: Int = -1


    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.interfaz_admin)

        listaPedidosLayout = findViewById(R.id.lista_pedidos)
        cardViewDetalle = findViewById(R.id.card_view_detalle)
        txtNombreCliente = findViewById(R.id.txt_nombre_cliente)
        tablaDetalle = findViewById(R.id.tabla_detalle)
        totalPedido = findViewById(R.id.total_pedido)
        btnAprobar = findViewById(R.id.btn_aprobar)
        btnCancelar = findViewById(R.id.btn_cancelar)

        cardViewDetalle.visibility = View.GONE

        cargarPedidosPendientes()
        configurarBotones()
        menuOpciones()
        AlertaBajoStock()


    }

    private fun cargarPedidosPendientes() {
        val url = "http://10.0.2.2/proyecto_F2/ventana_admin/listar_pedido.php"
        val requestQueue = Volley.newRequestQueue(this)

        val jsonRequest = JsonArrayRequest(Request.Method.GET, url, null,
        { response ->
            listaPedidosLayout.removeAllViews()
            for (i in 0 until response.length()) {
                val pedido = response.getJSONObject(i)
                val idPedido = pedido.getInt("Id_Pedido")
                val nombreCliente = pedido.getString("Nombre_Cliente")

                val btnPedido = Button(this).apply {
                    text = "Pedido $idPedido - $nombreCliente"
                    setOnClickListener { mostrarDetallePedido(idPedido) }
                    setBackgroundResource(R.drawable.boton_dinamico)
                    setTextColor(0xFFFFFFFF.toInt())

                    val params = LinearLayout.LayoutParams(
                        LinearLayout.LayoutParams.MATCH_PARENT,
                        LinearLayout.LayoutParams.WRAP_CONTENT
                    )
                    params.setMargins(10, 20, 10, 20)
                    layoutParams = params
                }
                listaPedidosLayout.addView(btnPedido)
            }
        }, { error ->
            Toast.makeText(this, "Error cargando pedidos: ${error.message}", Toast.LENGTH_LONG).show()
     })
        requestQueue.add(jsonRequest)
    }

    private fun mostrarDetallePedido(idPedido: Int) {
        pedidoActualId = idPedido
        val url = "http://10.0.2.2/proyecto_F2/ventana_admin/obtener_detalle_pedido.php?id_pedido=$idPedido"
        val requestQueue = Volley.newRequestQueue(this)

        val jsonRequest = JsonObjectRequest(Request.Method.GET, url, null,
            { response ->
                val nombreCliente = response.getString("Nombre_Cliente")
                val total = response.getDouble("Total")
                val productos = response.getJSONArray("productos")

                txtNombreCliente.text = "#$idPedido - $nombreCliente"
                val formatCOP = NumberFormat.getCurrencyInstance(Locale("es", "CO"))
                formatCOP.maximumFractionDigits = 0
                totalPedido.text = "TOTAL: ${formatCOP.format(total)}"
                tablaDetalle.removeViews(1, tablaDetalle.childCount -1)

                val encabezado = TableRow(this)

                val productoHeader = TextView(this).apply {
                    layoutParams = TableRow.LayoutParams(0, TableRow.LayoutParams.WRAP_CONTENT, 1f)
                    text = "PRODUCTO"
                    gravity = Gravity.CENTER
                    setPadding(16,24,16,24)
                    setTypeface(null, android.graphics.Typeface.BOLD)
                    setBackgroundResource(R.drawable.borde_celda)
                    setTextColor(Color.BLACK)
                }

                val cantidadHeader = TextView(this).apply {
                    layoutParams = TableRow.LayoutParams(0, TableRow.LayoutParams.WRAP_CONTENT, 1f)
                    text = "CANTIDAD"
                    gravity = Gravity.CENTER
                    setPadding(16,24,16,24)
                    setTypeface(null, android.graphics.Typeface.BOLD)
                    setBackgroundResource(R.drawable.borde_celda)
                    setTextColor(Color.BLACK)
                }

                val precioHeader = TextView(this).apply {
                    layoutParams = TableRow.LayoutParams(0, TableRow.LayoutParams.WRAP_CONTENT, 1f)
                    text = "PRECIO"
                    gravity = Gravity.CENTER
                    setPadding(16,24,16,24)
                    setTypeface(null, android.graphics.Typeface.BOLD)
                    setBackgroundResource(R.drawable.borde_celda)
                    setTextColor(Color.BLACK)
                }

                encabezado.addView(productoHeader)
                encabezado.addView(cantidadHeader)
                encabezado.addView(precioHeader)
                tablaDetalle.addView(encabezado)

                for (i in 0 until productos.length()) {
                    val prod = productos.getJSONObject(i)
                    val fila = TableRow(this)

                    val nombre = TextView(this)
                    nombre.layoutParams = TableRow.LayoutParams(0, TableRow.LayoutParams.WRAP_CONTENT, 1f)
                    nombre.text = prod.getString("producto")
                    nombre.setTypeface(null, android.graphics.Typeface.BOLD)
                    nombre.gravity = Gravity.CENTER
                    nombre.setPadding(16,24,16,24)
                    nombre.setBackgroundResource(R.drawable.borde_celda)
                    nombre.setTextColor(Color.BLACK)

                    val cantidad = TextView(this)
                    cantidad.layoutParams = TableRow.LayoutParams(0, TableRow.LayoutParams.WRAP_CONTENT, 1f)
                    cantidad.text = prod.getString("cantidad")
                    cantidad.setTypeface(null, android.graphics.Typeface.BOLD)
                    cantidad.gravity = Gravity.CENTER
                    cantidad.setPadding(16,24,16,24)
                    cantidad.setBackgroundResource(R.drawable.borde_celda)
                    cantidad.setTextColor(Color.BLACK)

                    val precio = TextView(this)
                    precio.layoutParams = TableRow.LayoutParams(0, TableRow.LayoutParams.WRAP_CONTENT, 1f)
                    precio.text = prod.getString("precio")
                    precio.setTypeface(null, android.graphics.Typeface.BOLD)
                    precio.gravity = Gravity.CENTER
                    precio.setPadding(16,24,16,24)
                    precio.setBackgroundResource(R.drawable.borde_celda)
                    precio.setTextColor(Color.BLACK)

                    fila.addView(nombre)
                    fila.addView(cantidad)
                    fila.addView(precio)

                    tablaDetalle.addView(fila)
                }

                cardViewDetalle.visibility = View.VISIBLE
            },
            { error ->
                Toast.makeText(
                    this,
                    "Error cargando detalle del pedido: ${error.message}",
                    Toast.LENGTH_LONG
                ).show()
            })
        requestQueue.add(jsonRequest)


    }

    private fun configurarBotones(){
        btnAprobar.setOnClickListener {
            actualizarEstadoPedido("aprobado")
        }

        btnCancelar.setOnClickListener {
            actualizarEstadoPedido("cancelado")
        }
    }

    private fun actualizarEstadoPedido(estado: String){
        if(pedidoActualId == -1) return

        val url = "http://10.0.2.2/proyecto_F2/ventana_admin/actualizar_estado_pedido.php"
        val request = object : StringRequest(Method.POST, url,
            {
                Toast.makeText(this, "pedido $estado", Toast.LENGTH_SHORT).show()
                cardViewDetalle.visibility = View.GONE
                cargarPedidosPendientes()
            }, {error ->
                Toast.makeText(this, "Error actualizando estado: ${error.message}", Toast.LENGTH_LONG).show()
            })
    {
        override fun getParams(): Map<String, String> {
            return mapOf(
                "id_pedido" to pedidoActualId.toString(),
                "estado" to estado
            )
        }
    }

    Volley.newRequestQueue(this).add(request)

    }

    private fun menuOpciones(){
        val btnMenu = findViewById<ImageView>(R.id.menu)
        btnMenu.setOnClickListener {
            val inflater = layoutInflater
            val popupView = inflater.inflate(R.layout.menu_lateral, null)


            val popupWindow = PopupWindow(
                popupView,
                listaPedidosLayout.width,
                listaPedidosLayout.height,
                true

            )

            popupWindow.elevation = 10f

            val location = IntArray(2)
            btnMenu.getLocationOnScreen(location)

            popupWindow.showAtLocation(
                listaPedidosLayout,
                Gravity.TOP or Gravity.START,
                location[0],
                location[1] + 220
            )

            val btnPanelAdmin = popupView.findViewById<Button>(R.id.btn_panel_admin)
            val btnCerrarSesion = popupView.findViewById<Button>(R.id.btn_cerrar_seccion)

            btnPanelAdmin.setOnClickListener {
                val url = "http://10.0.2.2/proyecto_F2/Panel_Admin_Superior/Public/"
                val intent = Intent(Intent.ACTION_VIEW, Uri.parse(url))
                startActivity(intent)
            }

            btnCerrarSesion.setOnClickListener {
                val intent = Intent(this, MainActivity::class.java)
                startActivity(intent)
                finish()
            }
        }
    }

    private fun AlertaBajoStock(){
        val url = "http://10.0.2.2/proyecto_F2/ventana_admin/productos_bajo_stock.php"
        val requestQueue = Volley.newRequestQueue(this)

        val request = JsonArrayRequest(Request.Method.GET, url, null,
            { response ->
                for (i in 0 until response.length()) {
                    val producto = response.getJSONObject(i)
                    val nombre = producto.getString("Nombre_Producto")
                    val cantidad = producto.getInt("Cantidad_en_Stock")

                    mostrarPopupAlerta(nombre, cantidad)
                }
            },
            { error ->
                Toast.makeText(this, "Error verificando productos: ${error.message}", Toast.LENGTH_LONG).show()
            })

        requestQueue.add(request)


    }

    private fun mostrarPopupAlerta(nombre: String, cantidad: Int) {
        val inflater = LayoutInflater.from(this)
        val view = inflater.inflate(R.layout.alerta_productos, null)

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
        fondoOscuro.addView(view, layoutParams)

        val rootView = window.decorView.findViewById<FrameLayout>(android.R.id.content)
        rootView.addView(fondoOscuro)

        view.findViewById<TextView>(R.id.tvMensajeAlerta).text = "⚠️ El producto \"$nombre\" está a punto de agotarse. ($cantidad inidades restantes)."

        view.findViewById<Button>(R.id.btnAceptarAlerta).setOnClickListener{
            rootView.removeView(fondoOscuro)
        }


    }




}
