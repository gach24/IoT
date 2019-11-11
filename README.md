# IoT
El proyecto se divide en cuatro grandes boques diferenciados

## El programa arduino que recoge la temperatura y humedad y los transmite a un servidor a través de un móulo wifi

## El servidor apache que recibe los datos y los graba en la base de datos y por otra parte tambien explota dichos datos mostrándolos en gráficas

Dentro del servidor web tenemos dos grandes bloques

### La inserción de los datos en la base de datos

Para esta funcionalidad tenemos unicamente una página dentro de la carpeta del servidor llamada **insert.php**
Dentro de esta página tenemos un bloque de código php que tiene como misión insertar los datos enviados a través del módulo wifi de la placa arduino

El código comienza con la declaracion de las varibles que contendrán los parámetros de conexión a la base de datos

```php
<?php
    $user = "root"; // Usuario de la base de datos
    $pass = "root"; // Contraseña del usuario
    $host = "localhost"; // Dirección ip o nombre dns del servidor de base de datos
    $db   = "temperaturesdb"; // Nombre de la base de datos en donde almacenaremos los datos de temperatura y humedad
    ...
?>
```

A continuación creo la conexión de la base de datos y compruebo que no ha habido error

```php
<?php
    ...
    $conn = new mysqli($host, $user, $pass, $db); // Conexión a la base de datos

    mysqli_set_charset($conn, "utf-8");

    /*
     * Si la conexión falla muestro la causa del error de conexión !Ojo debe estar configurado el php!
     */
    if ($conn->connect_error) 
        die("Connection failed: " . $conn->connect_error);
?>
```

La página espera recibir peticiones GET a través del protocolo http, estas peticiones será realizadas mediante comandos AT dentro del programa arduino, por lo que cuando recibidos una recogemos los parametros de la cadena url
Por ejemplos si la petición es: http://localhost/insert.php?temperature=20&humidity=40
Los parámetros serían
    - **temperature** con valor 20
    - **humidity** con valor 40
Por lo tanto, mediante código php pasamos a recoger dichos valores

```php
<?php
    ...
    $temperature = $_GET["temperature"];
    $humidity = $_GET["humidity"];
    ...
?>
```

A continuación pasamos a componer la sentencia sql de la base de datos que nos introducira dichos valores (temperatura y humedad) dentro de tabla de la base de datos.
Además de dichos valores recogemos también mediante la función "NOW()" la fecha y hora en la que se hizo la medición

```php
<?php
    ...
    $sql = "INSERT INTO temperatures(temperature, humidity, date) VALUES(" . $temperature . "," . $humidity .", NOW())";
    ...
?>
```

Finalmente enviamos la senticia de inserción sql a la base de datos

```php
<?php
    ...
    // Si lanzon query de inserción y no hay error mostramos mensaje "Nuevo registro ..." (solo necesiario para depuración)
    if ($conn->query($sql))
        echo "Nuevo registro insertado";
    else // En caso de error mostramos la causa
        echo "Error" . $sql . "<br />" . $conn->error;
    ...
?>
```

## La base de datos que almacena todos los registros de temperatura y humedad
En cuanto a la base de datos, se trata de una base de datos mysql como se ha dicho anteriormente.
Asumiendo que somos el usuario root de la base de datos o que disponemos de los permisos necesarios, es necesario crear una única tabla donde se añadiran los registros compuestos por:

- id. Clave primaria de la tabla
- temperature. Donde se almacenará la temperatura medida
- humidity. Donde se almacenará la humedad medida
- date. Donde se almacenara la fecha y hora de la medición

La sentencia de creación de la tabla, que se llamara temperatures, en mysql es:

```sql
CREATE TABLE temperatures (
  id int NOT NULL AUTO_INCREMENT,
  temperature float NOT NULL,
  humidity float NOT NULL,
  date datetime NOT NULL,
  PRIMARY KEY (id)
)
```
