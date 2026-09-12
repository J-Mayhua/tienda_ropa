# Tienda Ropa

E-commerce en PHP 8.2 con arquitectura MVC personalizada, MySQL/MariaDB,
sesiones PHP para el carrito y pagos mediante QR Yape.

## Estado del proyecto

El proyecto incluye:

- Router centralizado por `accion` en `publico/index.php`.
- Autoload PSR-4 mediante Composer.
- Control de acceso RBAC para clientes y administradores.
- Contraseñas protegidas con bcrypt.
- Consultas PDO con prepared statements.
- CSRF obligatorio para solicitudes POST.
- Sesiones con cookies `Secure`, `HttpOnly` y `SameSite=Lax`.
- Control básico de intentos fallidos de inicio de sesión.
- Validación de uploads con MIME real, tamaño limitado y nombres aleatorios.
- Control transaccional de stock con `SELECT ... FOR UPDATE`.
- Headers CSP, `X-Frame-Options` y `X-Content-Type-Options`.
- Logging con Monolog y rotación diaria.
- PHPUnit con mocks PDO, sin acceso a una base real.
- Vistas con escapado contextual, mensajes accesibles y tablas responsive.

## Requisitos

- PHP 8.2 o superior.
- Composer 2.
- MySQL 8 o MariaDB 10.4 o superior.
- Apache u otro servidor compatible con PHP.
- Extensiones PHP: `pdo_mysql`, `fileinfo`, `mbstring`, `openssl`.

## Arquitectura

```text
Solicitud HTTP
    |
publico/index.php
    |
Router accion => [Controlador, metodo]
    |
Controladores
    |
Modelos PDO
    |
MySQL/MariaDB
    |
Vistas PHP + CSS + JavaScript
```

### Estructura principal

```text
Tienda_ropa/
├── aplicacion/
│   ├── controladores/       # Casos de uso HTTP
│   ├── modelos/             # Acceso a datos
│   ├── soporte/             # Validador y Logger
│   └── vistas/              # Templates PHP
├── configuracion/
│   ├── config.php           # Entorno, sesión y conexión PDO
│   ├── csrf.php             # Generación y validación CSRF
│   └── uploads.php          # Validación segura de archivos
├── publico/
│   ├── index.php            # Front controller y router
│   └── recursos/            # CSS, JavaScript e imágenes
├── tests/                   # Tests unitarios PHPUnit
├── .env.example             # Plantilla de configuración
├── composer.json
├── phpunit.xml
└── README.md
```

## Instalación

1. Clona el repositorio y entra en su directorio.

2. Instala dependencias:

```bash
composer install
```

3. Crea el archivo de entorno:

```bash
copy .env.example .env
```

En Linux/macOS:

```bash
cp .env.example .env
```

4. Configura `.env`:

```dotenv
APP_ENV=development
APP_DEBUG=true

DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=tienda_ropa
DB_USER=usuario_bd
DB_PASSWORD=contrasena_bd
```

No versiones `.env`. El archivo está excluido mediante `.gitignore`.

5. Crea las tablas `usuarios`, `productos`, `pedidos` y `detalles_pedido`
   usando el esquema SQL disponible en el proyecto o en tu herramienta de
   administración de MySQL/MariaDB.

6. Configura Apache para que `publico/` sea el document root. En XAMPP,
   también puedes acceder mediante:

```text
http://localhost/Tienda_ropa/publico/
```

## Configuración de seguridad

### CSRF

Los formularios POST incluyen `csrf_field()`. El punto de entrada valida el
token antes de ejecutar la acción y compara valores con `hash_equals()`.

### Sesiones

La sesión usa:

- Nombre fijo `tienda_ropa_session`.
- `secure=true`.
- `httponly=true`.
- `samesite=Lax`.
- `session.use_only_cookies=1`.
- `session.use_strict_mode=1`.

En producción, sirve siempre la aplicación mediante HTTPS.

### Autenticación y autorización

- `password_hash()` y `password_verify()` protegen contraseñas.
- `session_regenerate_id(true)` se ejecuta después de iniciar sesión.
- Las funciones administrativas requieren sesión con rol `admin`.
- La creación de administradores no está disponible para usuarios no
  autorizados.

### Inventario

El checkout abre una transacción, bloquea filas de productos con
`SELECT ... FOR UPDATE`, valida stock, recalcula precios y descuenta unidades
antes de confirmar el pedido. Cualquier fallo ejecuta rollback.

### Uploads

Los comprobantes e imágenes de producto:

- Verifican `is_uploaded_file()`.
- Validan MIME real mediante `finfo`.
- Limitan tamaño máximo.
- Usan nombres aleatorios generados con `random_bytes()`.
- No confían en la extensión enviada por el cliente.

### Headers HTTP

El punto de entrada añade:

- Content Security Policy.
- `X-Frame-Options: DENY`.
- `X-Content-Type-Options: nosniff`.

## Frontend

Las vistas usan PHP server-side sin framework CSS. La convención actual es:

- Clases en español.
- Formato `kebab-case`.
- Componentes reutilizables en `estilos.css`.
- Mensajes comunes en `aplicacion/vistas/plantillas/mensajes.php`.
- Tablas administrativas dentro de `.tabla-responsive`.
- Datos dinámicos escapados con:

```php
htmlspecialchars($valor, ENT_QUOTES, 'UTF-8')
```

El catálogo conserva JavaScript vanilla para filtros y efectos visuales.
Los selectores JavaScript y CSS usan la misma nomenclatura en español.

## Ejecución de tests

Ejecuta la suite completa:

```bash
vendor/bin/phpunit
```

Los tests cubren:

- Registro y autenticación.
- Contraseña incorrecta.
- Email duplicado.
- Carrito con stock insuficiente.
- Creación de pedidos.
- Commit y rollback de transacciones de pago.

Los modelos reciben PDO por inyección de dependencias en tests. No se conecta
a una base de datos real.

## Logging

Monolog escribe logs rotativos en:

```text
logs/app-YYYY-MM-DD.log
```

La carpeta `logs/` no debe versionarse. Los niveles usados son `info`,
`warning` y `error`.

## Convenciones de desarrollo

- Mantén los nombres públicos de controladores y modelos.
- Usa prepared statements para toda consulta con datos externos.
- Valida autorización en servidor, nunca solo en la vista.
- Escapa datos según el contexto HTML, atributo o URL.
- No guardes secretos en el repositorio.
- Ejecuta `php -l` sobre archivos PHP modificados.
- Ejecuta PHPUnit antes de integrar cambios.
- No introduzcas frameworks web.

## Dependencias

Dependencias de producción:

- `vlucas/phpdotenv`: carga segura de variables de entorno.
- `monolog/monolog`: logging estructurado y rotativo.

Dependencias de desarrollo:

- `phpunit/phpunit`: pruebas unitarias.

Las versiones están fijadas en `composer.lock`.

## Limitaciones conocidas

- El pago Yape usa flujo de comprobante; no integra una API bancaria.
- El rate limiting actual usa estado de sesión y no reemplaza un WAF o
  limitador distribuido.
- Deben configurarse HTTPS, permisos de filesystem y secretos reales antes de
  desplegar en producción.

## Licencia y autoría

Proyecto académico y de desarrollo para gestión de una tienda de ropa.
Consulta las condiciones de distribución definidas por el propietario del
repositorio antes de reutilizarlo.
