

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    numero VARCHAR(15),
    password VARCHAR(255) NOT NULL,
    tipo ENUM('estudiante', 'empresa','admin') NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE empresas (
    id INT PRIMARY KEY, -- Relaciona 1:1 con usuarios.id
    nombre_unidad VARCHAR(100) NOT NULL,
    rfc VARCHAR(13) UNIQUE NOT NULL,
    localidad VARCHAR(100) NOT NULL,
    domicilio VARCHAR(255) NOT NULL,
    telefono VARCHAR(15),
    programa VARCHAR(100),
    FOREIGN KEY (id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE estudiantes (
    id INT PRIMARY KEY, -- Relaciona 1:1 con usuarios.id
    matricula VARCHAR(20) UNIQUE NOT NULL,
    carrera VARCHAR(100) NOT NULL,
    FOREIGN KEY (id) REFERENCES usuarios(id) ON DELETE CASCADE
);