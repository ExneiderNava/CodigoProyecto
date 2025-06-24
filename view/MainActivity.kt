package com.example.proyecto_ebenezer.view

import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.widget.Button
import android.widget.EditText
import androidx.activity.ComponentActivity
import com.example.proyecto_ebenezer.R

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.incio_de_seccion)

        val codigoInput = findViewById<EditText>(R.id.ps_codigo)
        val botonIngresar = findViewById<Button>(R.id.bt_ingresar)

        botonIngresar.setOnClickListener {
            val codigo = codigoInput.text.toString()

            if (codigo == "Xre65g"){
                val link = Intent(Intent.ACTION_VIEW)
                link.data = Uri.parse("https://www.figma.com/design/ihqhvGcd8VvxyE5GLJ3adV/Untitled?node-id=0-1&p=f&t=AjqtoIk9x9K2YT8C-0")
                startActivity(link)

            }else if(codigo == "cliente"){
                val intent = Intent(this, InterfazClienteActivity::class.java)
                startActivity(intent)
            }
            else {
                codigoInput.error = "Código incorrecto"
            }

        }




    }
}





