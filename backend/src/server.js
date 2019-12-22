'use strict';

// Constants
const PORT_EXPRESS        = '8080';
const HOST_EXPRESS        = '0.0.0.0';
const PORT_MONGO          = '27017';
const HOST_MONGO          = 'db';
const DB_MONGO            = 'datadb'


const mongoose  = require('mongoose');
const cors      = require('cors');
const express   = require('express');


var dataSchema = new mongoose.Schema({
  temperature: { 
    type: Number, 
    required: [true, "Temperature is necesary"] 
  },
  humidity: {
    type: Number, 
    required: [true, "Humidity is necesary"] 
  },
  created: {
    type: Date, 
    required: true,
    default: Date.now
  }
});

var Measure = mongoose.model('Measure', dataSchema);




// App
var app = express();

/*
 * Para permitir llamadas javascript a otros dominios
 * Sin embargo utilizamos el paquete de node cors
app.use((req, res, next) => {
  res.header('Access-Control-Allow-Origin', '*');
  res.header('Access-Control-Allow-Headers', 'Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Allow-Request-Method');
  res.header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
  res.header('Allow', 'GET, POST, OPTIONS, PUT, DELETE');
  next();
});
 */

app.use(cors());

app.get('/insert', (req, res, next) => {

  let t = Number(req.query.temperature) || 0;
  let h = Number(req.query.humidity) || 0;

  let measure = new Measure({ temperature: t, humidity: h });

  measure.save()
    .then(newMeasure => res.status(200).json({ok: true, new: newMeasure}))
    .catch(err => res.status(500).json({ok: false, message: "No se ha podido insertar en la base de datos" }));
});

app.get('/minutes', (req, res, next) => {
  let time = new Date(Date.now() - 1000 * 60 * 10);
  Measure.find({ created: {$gte: time}}).exec()
    .then(data => res.status(200).json({ok: true, measures: data}))
    .catch(err => res.status(500).json({ok: false, message: "No se ha podido conectar a la base de datos" }));
});


app.get('/',  (req, res, next) => {

  Measure.find({}).exec()
    .then(data => {
      res.status(200).json({ok: true, measures: data })
    })
    .catch(err => res.status(500).json({ok: false, message: "No se ha podido conectar a la base de datos" }));

});




/**
 * Necesario ya que el contenedor de mongo, tarda unos segundos en estar disponible, por lo que se retrasa la conexión 5 segundos
 */
setTimeout(function() {
  var mongoConnectionString = `mongodb://dev:dev@${ HOST_MONGO }:${ PORT_MONGO }/${ DB_MONGO }`;
  mongoose.connect(mongoConnectionString, {useNewUrlParser: true})
    .then(
      () => {
        console.log('Running mongodb on: \x1b[42m%s\x1b[0m', mongoConnectionString);

        var expressListenString = `http://${HOST_EXPRESS}:${PORT_EXPRESS}`;      
        app.listen(PORT_EXPRESS, HOST_EXPRESS, () => {
          console.log('Running express on: \x1b[42m%s\x1b[0m', expressListenString);
        });
      },
      err => { throw err }
  );
}, 5000);


