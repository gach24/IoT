'use strict';

const express = require('express');

// Constants
const PORT = 8080;
const HOST = '0.0.0.0';

// App
const app = express();
app.get('/', (req, res, next) => {
  res.status(200).json({
    ok: true,
    msg: 'Hello world'
  });
});


/**
 * Listen express on 0.0.0.0 host and 8080 port
 * app.listen(PORT, HOST, () => console.log('Express listening on port 3000 ...'));
 */
app.listen(PORT, HOST);
console.log('Running on: \x1b[42m%s\x1b[0m', `http://${HOST}:${PORT}`);