# IoT
La funcionalidad de este proyecto es el registro de datos (incialmente temperatura y humedad) a través de una placa arduino con diferentes sensores

Los datos registrados serán transmitidos por la red a un servidor nodejs que se encargará de persistirlos en una base de datos mongodb, por otra parte el mismo servidor nodejs ofrece los datos a través de una api rest que serán consumidos inicialmente por un cliente web (en un futuro los disitintos tipos de clientes se irán aumentando) mediante consultas ajax que recibirán datos en formato json

## Requisitos 
Es necesaria la instalación de [docker](https://docs.docker.com/install/) y [docker-compose](https://docs.docker.com/compose/install/)

## Puesta en marcha
Una vez clonado el proyecto, situarse en el directorio raiz del mismo

Pasos:
1. Creación del volumen para la persistencia de los datos de mongo
```console
docker volume create mongo-volume
```

2. Arrancar los contenedores
```console
docker-compose up -d
```




