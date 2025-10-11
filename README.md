[![Review Assignment Due Date](https://classroom.github.com/assets/deadline-readme-button-22041afd0340ce965d47ae6ef1cefeee28c7c493a6346c4f15d667ab976d596c.svg)](https://classroom.github.com/a/VBVV2dCM)
# 📘 DWES02 - Tarea de Evaluación

## Página de Gestión de Vehículos

### 📝 Descripción general

Desarrollarás una web tipo SSR para una empresa de gestión de vehículos. Esta dispondrá de dos funcionalidades:

- Recuperar los datos de un vehículo introduciendo su ID.
- Almacenar un vehículo nuevo, introduciendo sus datos a través de la interfaz gráfica.

### 🎯 Objetivos de aprendizaje

- Entender los principios de programación básicos e intermedios.
- Desarrollar código empleando POO.
- Trabajar con estructuras de datos.
- Conocer y desarrollar la arquitectura MVC.

### 🛠️ Ejercicios

#### Ejercicio 1: Arquitectura

- Crea una arquitectura MVC e incluye los ficheros que te facilito en el apartado de *recursos* en lod directorios que corresponda.
- Al iniciar la aplicación se debe cargar la interfaz gráfica `index.html`, y esta llamará al *front-controller*.
- La aplicación empleará *namespaces* y el fichero `autoload.php` generado mediante *Composer* para gestionar las rutas.
- Crea un modelo de datos basado en tres clases. Utilizando la herencia, representa los diferentes tipos de vehículos:
  - `Vehiculo`
    - id `int`
    - marca `string`
    - modelo `string`
    - anio `int`
    - tipo `string`
  - `Moto`
    - sidecar `bool`
  - `Coche`
    - puertas `int`

#### Ejercicio 2: Recuperar un vehículo mediante su ID

- Cuando se introduzca un ID en la interfaz y se pulse *Buscar*, se llamará al método `getById()` del controlador que realizará lo siguiente:
  
  - Llamar al método `leerVehiculos()` que:
    - Accederá a la ruta donde se encuentra el fichero `vehiculos_bbdd.php`.
    - Parseará los diferentes vehículos a objetos de tipo `Coche` o `Moto`, según el atributo`tipo` 
    - Devolverá un array de objetos con todos los vehículos.
  - Comparará el ID recibido, con el de los vehículos del array y devolverá el vehículo cuyo `id` coincida. 
  - Se mostrarán los datos del vehiculo en una nueva interfaz `vehiculo_get.html`

#### Ejercicio 3: Almacenar un vehículo en el fichero JSON.

- Cuando se introduzca un vehículo en la interfaz y se pulse *Guardar*, se llamará al método `store()` del controlador que realizará lo siguiente:
  - Usando el método `leerVehiculos()` del ejercicio anterior, leer todos los vehiculos de `vehiculos_bbdd.php`
  - Crear un objeto `Coche` o `Moto`, según corresponda, con los datos intorducidos a través de la interfaz.
  - Mostrar todos los vehiculos en una interfaz `vehiculo_post.html`

**⚠️Importante:**

- *Te facilito un fichero `vehiculos_prueba.txt` con diferentes vehiculos de prueba para que puedas copiar y pegar en la caja de texto de la interfaz gráfica*

- *Estos vehiculos están en formato JSON, de manera que cuando recibas el texto en el front controller, deberas usar `json.decode()` para convertirlo a un array asociativo. Aquí te dejo un [ejemplo](https://www.w3schools.com/Php/func_json_decode.asp).*
