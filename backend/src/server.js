'use strict';

// Constants
const PORT        = 8080;
const HOST = '0.0.0.0';




const express   = require('express');
const mongoose  = require('mongoose');





/**
mongoose.connection.openUri('mongodb://dev:dev@db:27017/temperatures', (err, res) => {
  if (err)
    throw err;
  console.log('Mongo running on: \x1b[42m%s\x1b[0m', 'mongodb://db/temperatures:27012')
});
 */



// App
const app = express();
app.get('/', (req, res, next) => {
  res.status(200).json({
    ok: true,
    msg: 'Hello world'
  });
});

setTimeout(function() {
  mongoose.connect('mongodb://dev:dev@db:27017/temperatures', {useNewUrlParser: true})
    .then(
      () => {
        console.log('Running mongodb on: \x1b[42m%s\x1b[0m', 'mongodb://dev:dev@db:27017/temperatures')
        /**
          * Listen express on 0.0.0.0 host and 8080 port
          * app.listen(PORT, HOST, () => console.log('Express listening on port 3000 ...'));
          */
        app.listen(PORT, HOST);
        console.log('Running express on: \x1b[42m%s\x1b[0m', `http://${HOST}:${PORT}`);
      },
      err => { throw err }
  );

}, 10000);


