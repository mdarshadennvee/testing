const express = require('express');
const mysql = require('mysql');
const app = express();
const bodyParser = require('body-parser');

app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

const connection = mysql.createConnection({
  host: 'localhost',
  user: process.env.DB_USER ,
  password: process.env.DB_PASSWORD,
  database: 'test'
});

connection.connect(err => {
  if (err) throw err;
  console.log('Connected to database!');
});

app.get('/user/:id', (req, res) => {
  const userId = req.params.id;
  // SQL Injection vulnerability
  const query = `SELECT * FROM users WHERE id = ${userId}`;
  connection.query(query, (err, results) => {
    if (err) throw err;
    res.json(results);
  });
});

app.post('/message', (req, res) => {
  const message = req.body.message;
  // XSS vulnerability
  res.send(`<h1>${message}</h1>`);
});

app.post('/deserialize', (req, res) => {
  const data = req.body.data;
  // Insecure deserialization vulnerability
  const obj = eval(`(${data})`);
  res.json(obj);
});

app.listen(3000, () => {
  console.log('Server running on port 3000');
});
