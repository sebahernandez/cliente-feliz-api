# Cliente Feliz API

API RESTful para gestionar ofertas de empleo y postulaciones de candidatos.

## Requisitos

- PHP 7.4 o superior
- MySQL/MariaDB
- Servidor web (Apache/Nginx)
- MAMP, XAMPP o similar para desarrollo local

## Instalación

1. Clonar el repositorio:

```bash
git clone [url-del-repositorio]
cd cliente-feliz-api
```

2. Configurar la base de datos:

   - Crear una base de datos llamada `cliente_feliz_db`
   - Importar el esquema de la base de datos (no incluido en este repositorio)
   - Revisar y configurar las credenciales en `/config/db.php` si es necesario

3. Configurar el servidor web para que apunte a la carpeta `/public` como directorio raíz

## Estructura del Proyecto

```
cliente-feliz-api/
├── config/           # Configuración (base de datos)
├── controllers/      # Controladores de la API
├── models/           # Modelos de datos
├── public/           # Punto de entrada de la API
└── test/             # Pruebas
```

## Endpoints de la API

### Ofertas de Empleo

#### Obtener todas las ofertas activas

- **Método**: GET
- **URL**: `/`
- **Respuesta**: Lista de ofertas de empleo activas

#### Crear una nueva oferta

- **Método**: POST
- **URL**: `/`
- **Datos**:
  ```json
  {
    "titulo": "Desarrollador PHP Senior",
    "descripcion": "Buscamos desarrollador con 5 años de experiencia..."
  }
  ```
- **Respuesta**: Confirmación y ID de la oferta creada

#### Actualizar una oferta

- **Método**: PUT
- **URL**: `/`
- **Datos**:
  ```json
  {
    "id": 1,
    "titulo": "Nuevo título de la oferta",
    "descripcion": "Nueva descripción de la oferta"
  }
  ```
- **Respuesta**: Confirmación de actualización

#### Desactivar una oferta

- **Método**: PATCH
- **URL**: `/`
- **Datos**:
  ```json
  {
    "id": 1
  }
  ```
- **Respuesta**: Confirmación de desactivación

### Postulaciones

#### Registrar una postulación

- **Método**: POST
- **URL**: `/postulantes`
- **Datos**:
  ```json
  {
    "oferta_id": 1,
    "nombre_candidato": "Juan Pérez",
    "correo": "juan@ejemplo.com"
  }
  ```
- **Respuesta**: Confirmación y ID de la postulación

#### Ver estado de una postulación

- **Método**: GET
- **URL**: `/postulantes?id=1`
- **Respuesta**: Estado actual de la postulación

#### Listar todas las postulaciones

- **Método**: GET
- **URL**: `/postulantes`
- **Respuesta**: Lista de todas las postulaciones

#### Listar postulaciones por oferta

- **Método**: GET
- **URL**: `/postulantes?oferta_id=1`
- **Respuesta**: Lista de postulaciones para una oferta específica

#### Cambiar estado de una postulación

- **Método**: PATCH
- **URL**: `/postulantes`
- **Datos**:
  ```json
  {
    "id": 1,
    "estado": "entrevista",
    "comentario": "Programar entrevista técnica"
  }
  ```
- **Respuesta**: Confirmación de cambio de estado

## Estados de Postulación

Los estados posibles para una postulación son:

- `recibida` (por defecto)
- `revisada`
- `entrevista`
- `rechazada`
- `aceptada`

## Ejemplo de Uso

### JavaScript (Fetch API)

```javascript
// Obtener todas las ofertas
fetch("https://tu-dominio.com/")
  .then((response) => response.json())
  .then((data) => console.log(data));

// Crear una postulación
fetch("https://tu-dominio.com/postulantes", {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
  },
  body: JSON.stringify({
    oferta_id: 1,
    nombre_candidato: "María González",
    correo: "maria@ejemplo.com",
  }),
})
  .then((response) => response.json())
  .then((data) => console.log(data));
```

### PHP

```php
// Obtener todas las ofertas
$ch = curl_init('https://tu-dominio.com/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$ofertas = json_decode($response, true);

// Crear una postulación
$datos = [
  'oferta_id' => 1,
  'nombre_candidato' => 'Pedro Sánchez',
  'correo' => 'pedro@ejemplo.com'
];

$ch = curl_init('https://tu-dominio.com/postulantes');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);
$resultado = json_decode($response, true);
```

## Notas Importantes

- Esta API utiliza JSON para todas las solicitudes y respuestas
- Las solicitudes POST, PUT y PATCH deben incluir la cabecera `Content-Type: application/json`
- Los errores se devuelven con un código HTTP apropiado y un mensaje de error en formato JSON

## Desarrollo y Contribución

1. Haz un fork del repositorio
2. Crea una rama para tu característica (`git checkout -b feature/nueva-caracteristica`)
3. Haz commit de tus cambios (`git commit -am 'Añadir nueva característica'`)
4. Haz push a la rama (`git push origin feature/nueva-caracteristica`)
5. Crea un Pull Request
