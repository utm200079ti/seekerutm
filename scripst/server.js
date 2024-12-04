//server.js

import express from "express";
import mysql from "mysql";

const express = require("express");
const mysql = require("mysql");
const app = express();
const PORT = 3000;

// Configuración de la conexión a la base de datos MySQL
const db = mysql.createConnection({
  host: 'db5016642491.hosting-data.io',
  user: 'dbu1342146',
  password: "S3eKerU7m*",
  database: 'dbs13488317',
});

// Conectar a la base de datos
db.connect((err) => {
  if (err) {
    console.error("Error al conectar a la base de datos:", err);
    return;
  }
  console.log("Conectado a la base de datos MySQL.");
});

