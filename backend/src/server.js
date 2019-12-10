'use strict';

// Constants
const PORT_EXPRESS        = '8080';
const HOST_EXPRESS        = '0.0.0.0';
const PORT_MONGO          = '27017';
const HOST_MONGO          = 'db';
const DB_MONGO            = 'datadb'



const express   = require('express');
const mongoose  = require('mongoose');

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

var Data = mongoose.model('Data', dataSchema);


// App
const app = express();


app.get('/', (req, res, next) => {

  res.status(200).json({
    ok: true,
    msg: 'Hello world'
  });
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


