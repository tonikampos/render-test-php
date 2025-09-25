# Render Test PHP - Contador de Visitas

Un sencillo contador de visitas desarrollado en PHP que utiliza PostgreSQL como base de datos, diseñado específicamente para ser desplegado en Render.

## 🚀 Características

- **Contador de visitas**: Lleva la cuenta de cuántas veces se ha visitado la página
- **Base de datos PostgreSQL**: Utiliza PostgreSQL para persistir el contador
- **Conexión segura**: Usa variables de entorno para la configuración de la base de datos
- **Diseño responsive**: Interfaz simple y atractiva
- **Preparado para Render**: Configurado para funcionar perfectamente en la plataforma Render

## 🛠️ Tecnologías utilizadas

- **PHP**: Lenguaje de programación principal
- **PostgreSQL**: Base de datos para almacenar el contador
- **PDO**: Para conexiones seguras a la base de datos
- **HTML5 & CSS3**: Para la interfaz de usuario

## 📋 Requisitos

- PHP 7.4 o superior
- PostgreSQL
- Variable de entorno `DATABASE_URL`

## ⚙️ Configuración para desarrollo local

1. **Clona el repositorio:**
   ```bash
   git clone https://github.com/tonikampos/render-test-php.git
   cd render-test-php
   ```

2. **Configura la base de datos PostgreSQL:**
   - Crea una base de datos en PostgreSQL
   - Crea la tabla necesaria:
     ```sql
     CREATE TABLE visitantes (
         id SERIAL PRIMARY KEY,
         contador INTEGER DEFAULT 0
     );
     
     INSERT INTO visitantes (contador) VALUES (0);
     ```

3. **Configura las variables de entorno:**
   - Crea un archivo `.env` (local) con:
     ```
     DATABASE_URL=postgres://usuario:contraseña@localhost:5432/nombre_bd
     ```

4. **Ejecuta en un servidor local:**
   ```bash
   php -S localhost:8000
   ```

## 🌐 Despliegue en Render

Este proyecto está optimizado para Render:

1. Conecta tu repositorio de GitHub con Render
2. Configura la variable de entorno `DATABASE_URL` en Render
3. Render detectará automáticamente que es un proyecto PHP
4. ¡Tu aplicación estará lista!

## 📁 Estructura del proyecto

```
render-test-php/
├── index.php          # Archivo principal de la aplicación
├── .gitignore         # Archivos ignorados por Git
└── README.md          # Este archivo
```

## 🔧 Funcionamiento

La aplicación:

1. Se conecta a PostgreSQL usando la variable de entorno `DATABASE_URL`
2. Incrementa el contador en la base de datos cada vez que se carga la página
3. Muestra el número total de visitas
4. Maneja errores de conexión de forma elegante

## 📝 Notas

- La aplicación usa PDO para conexiones seguras a la base de datos
- Todas las variables de entorno se manejan de forma segura
- El diseño es responsive y funciona en dispositivos móviles
- Incluye manejo de errores para conexiones fallidas

## 👨‍💻 Autor

Desarrollado para pruebas de despliegue en Render.