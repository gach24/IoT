'use strict';

const express = require('express');

// Constants
const PORT = 8080;
const HOST = '0.0.0.0';

// App
const app = express();
app.get('/', (req, res) => {
  res.send('Hello world\n');
});


/**
 * Listen express on 0.0.0.0 host and 8080 port
 * app.listen(PORT, HOST, () => console.log('Express listening on port 3000 ...'));
 */
app.listen(PORT, HOST);
console.log(`Running on http://${HOST}:${PORT}`);