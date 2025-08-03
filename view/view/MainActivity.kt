package com.example.proyecto_ebenezer.view

import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.util.Log
import android.widget.Button
import android.widget.EditText
import android.widget.Toast
import androidx.activity.ComponentActivity
import androidx.compose.ui.text.toLowerCase
import com.android.volley.Request
import com.android.volley.toolbox.JsonObjectRequest
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.example.proyecto_ebenezer.R
import org.json.JSONObject
import kotlin.math.log

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.incio_de_seccion)

        val codigoInput = findViewById<EditText>(R.id.ps_codigo)
        val botonIngresar = findViewById<Button>(R.id.bt_ingresar)

        conexionAlServidor()

        botonIngresar.setOnClickListener {
            val codigo = codigoInput.text.toString().trim()


            if (codigo.isEmpty()) {
                codigoInput.error = "Por favor ingrese su código"
                return@setOnClickListener
            }

            verificarCodigoEnServidor(codigo)

        }




    }

    fun conexionAlServidor(){
        val url = "http://10.0.2.2/conexion_bd/conexionBD.php"

        val request = StringRequest(
            Request.Method.GET,
            url,
            { response ->

                Toast.makeText(this@MainActivity, "Conexión exitosa", Toast.LENGTH_SHORT).show()
            },
            { error ->
                Log.e("VolleyError", "Error de conexión: ${error.message}", error)
                Toast.makeText(this@MainActivity, "Error: ${error.message}", Toast.LENGTH_LONG).show()
            }
        )

        Volley.newRequestQueue(this).add(request)


    }

    fun verificarCodigoEnServidor(codigo: String) {

        val url = "http://10.0.2.2/proyecto_F2/Login/login_usuario.php"
        val requestQueue = Volley.newRequestQueue(this@MainActivity)

        val jsonBody = JSONObject()
        jsonBody.put("codigo", codigo)

        val request = JsonObjectRequest(
            Request.Method.POST, url , jsonBody,
            { response ->
                val estado = response.getString("success").trim()
                if (estado == "exito"){
                    val rol = response.getString("rol").trim()
                    val idUsuario = response.getString("id_usuario").trim()

                    val sharedPref = getSharedPreferences("datos_usuario", MODE_PRIVATE)
                    val editor = sharedPref.edit()
                    editor.putString("id_usuario", idUsuario)
                    editor.apply()

                    when(rol){
                        "Estudiante" -> startActivity(Intent(this, InterfazClienteActivity::class.java))
                        "Administrador" -> startActivity(Intent(this, AdministradorActivity::class.java))
                        "Profesor" -> startActivity(Intent(this, InterfazClienteActivity::class.java))
                        "Empleado" -> startActivity(Intent(this, InterfazClienteActivity::class.java))
                        else -> {
                            Toast.makeText(this@MainActivity, "Rol no reconocido", Toast.LENGTH_LONG).show()
                            Log.e("login error", "Rol no reconocido: $rol")
                        }
                    }

                    } else {
                        val mensaje = response.getString("mensaje")
                        Toast.makeText(this, mensaje, Toast.LENGTH_SHORT).show()

                }
                },
            { error ->
                Toast.makeText(this, "Error al verificar: ${error.message}", Toast.LENGTH_SHORT).show()
            }
        )

        requestQueue.add(request)
    }
}







