'use strict';

// Constants
const PORT_EXPRESS        = '8080';
const HOST_EXPRESS        = '0.0.0.0';
const PORT_MONGO          = '27017';
const HOST_MONGO          = 'db';
const DB_MONGO            = 'temperatures'



const express   = require('express');
const mongoose  = require('mongoose');


// App
const app = express();
app.get('/', (req, res, next) => {
  res.status(200).json({
    ok: true,
    msg: 'Hello world'
  });
});

setTimeout(function() {
  mongoose.connect(`mongodb://dev:dev@${ HOST_MONGO }:${ PORT_MONGO }/${ DB_MONGO }`, {useNewUrlParser: true})
    .then(
      () => {
        console.log('Running mongodb on: \x1b[42m%s\x1b[0m', `mongodb://dev:dev@${ HOST_MONGO }:${ PORT_MONGO }/${ DB_MONGO }`);
      
        app.listen(PORT_EXPRESS, HOST_EXPRESS, () => {
          console.log('Running express on: \x1b[42m%s\x1b[0m', `http://${HOST_EXPRESS}:${PORT_EXPRESS}`);
        });
      },
      err => { throw err }
  );
}, 10000);


