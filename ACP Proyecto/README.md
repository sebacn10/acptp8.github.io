# ACP Proyecto — Portal de techo automatizado con Arduino

**Trabajo integrador de Programación Web: TP4, TP5, TP6, TP7 y TP8**  
**Institución:** EET N.º 3100 «República de la India»  
**Tecnologías:** PHP 8+, MySQL/MariaDB, HTML, CSS, JavaScript, PDO.

## Descripción
Este portal presenta el proyecto escolar de **techo corredizo automático** para proteger ropa ante la lluvia. Se conserva la información y las fotografías del sitio original y se integra un sistema de seguimiento mediante evaluaciones de funcionamiento, cuentas de usuario y administración.

La funcionalidad web registra observaciones humanas sobre el prototipo. **No controla físicamente la placa Arduino ni lee sensores en tiempo real**.

## Cómo ponerlo en marcha con XAMPP

1. Activar **Apache y MySQL** en XAMPP.
2. Copiar la carpeta `ACP Proyecto` a `C:\xampp\htdocs\ACP Proyecto`.
3. En `http://localhost/phpmyadmin`, entrar en **Importar** y seleccionar `database/schema.sql`. Esto crea la base `acp_proyecto`, sus tres tablas y los estados iniciales.
4. Copiar `.env.example` como `.env` dentro de la carpeta del proyecto. Revisar que DB_HOST, DB_PORT, DB_NAME, DB_USER y DB_PASSWORD coincidan con la instalación. **Nunca subir `.env` a GitHub.**
5. Visitar `http://localhost/ACP%20Proyecto/index.php`.
6. Registrar un usuario en `registro.php` y luego iniciar sesión desde `login.php`.
7. Para habilitar el administrador, luego de crear **tu propia cuenta**, editar su rol desde phpMyAdmin ejecutando: `UPDATE acp_proyecto.usuarios SET rol='admin' WHERE email='TU_CORREO_DE_PRUEBA';` (reemplazar por un correo real propio). Cerrar sesión e ingresar de nuevo para actualizar el rol de la sesión.
8. Entrar a `admin/index.php` para administrar evaluaciones y consultar los usuarios.

> La carpeta `.env` contiene configuración privada. La entrega incluye solo `.env.example`. El archivo `.htaccess` restringe su acceso vía Apache, pero se recomienda usar una instalación local y no publicar el sistema en Internet sin configurar HTTPS, respaldos y controles adicionales.

## TP4 — Migración HTML a PHP, modularización y renderizado del servidor

- Las páginas de presentación, proyecto, recursos, docentes, colegio, alumnos, opinión, curso, blog, cierre y demás contenidos originales fueron migradas a `.php`.
- Se creó `includes/header.php` con menú, enlaces activos y controles de cuenta, y `includes/footer.php` compartido.
- `includes/bootstrap.php` carga configuración desde `.env`, inicia la sesión y centraliza funciones para escapar salida (`acp_e`) y generar tokens CSRF.
- El título de cada página se define mediante `$titulo_pagina`.
- El CSS y el JavaScript se guardan en `estilos.css` y `script.js`.
- Las páginas `.html` anteriores quedan como accesos de compatibilidad que redirigen a las páginas PHP.

## TP5 — Formularios GET y POST, sanitización y persistencia

- **POST:** `Formulario.php` permite registrar la evaluación del techo; valida nombre, correo y observación en el servidor y la guarda en la tabla `evaluaciones` mediante PDO preparado.
- **GET:** `admin/registros.php?buscar=...&estado=...` filtra por datos del formulario y estado. Las búsquedas se hacen con parámetros preparados y la salida se escapa con `htmlspecialchars()`.
- Los errores y confirmaciones se muestran sin simular un guardado desde JavaScript.
- `registro.php` también procesa el alta de cuentas por POST.

## TP6 — MySQL y normalización 1FN–3FN

Esquema: `database/schema.sql`. Análisis detallado: [`docs/NORMALIZACION_TP6.md`](docs/NORMALIZACION_TP6.md).

| Tabla | Uso | Claves |
|---|---|---|
| `usuarios` | Nombre, email único, contraseña hasheada, rol y fecha | `id` PK |
| `estados_revision` | Estados maestros de las evaluaciones | `id` PK, `nombre` UNIQUE |
| `evaluaciones` | Registros de funcionamiento creados por usuarios | `id` PK, `usuario_id` FK, `estado_id` FK |

Se entregan consultas SQL demostrativas con JOIN, INSERT, SELECT, UPDATE y DELETE en `database/consultas.sql`. Las operaciones de escritura se realizan normalmente con parámetros PDO en el sistema.

## TP7 — Conexión PDO y CRUD administrativo

La conexión se realiza en `includes/database.php` con PDO y excepciones. El administrador contiene:

- **Create:** `Formulario.php` → inserta una evaluación.
- **Read:** `admin/registros.php` → listado y filtros GET; `panel.php` → evaluaciones propias.
- **Update:** `admin/editar.php` → permite modificar observación y estado.
- **Delete:** `admin/eliminar.php` → elimina mediante POST con token CSRF y confirmación.

Se usan JOIN para mostrar el autor y el estado, y las consultas SQL que reciben parámetros de usuario están preparadas. Las rutas de escritura se restringen a administradores.

## TP8 — Manejo de estado, autenticación y autorización

- **Registro** (`registro.php`): validación de datos, control de correo duplicado, `password_hash(PASSWORD_DEFAULT)` y sentencias preparadas.
- **Login** (`login.php`): comparación con `password_verify()`, `session_regenerate_id(true)` al iniciar sesión y almacenamiento en `$_SESSION` de `usuario_id`, `usuario_nombre` y `rol`.
- **Sesiones** (`includes/bootstrap.php`): `session_start()`, cookies HttpOnly, SameSite=Lax, modo Secure en HTTPS y modo estricto.
- **Protección de rutas** (`auth_guard.php` y `includes/auth.php`): usuarios no autenticados se redirigen a `login.php?error=acceso_denegado`.
- **Roles** (`admin/_guard.php`): solo el rol `admin` puede entrar en el panel administrativo; un usuario común recibe acceso denegado.
- **Logout** (`logout.php`): vacía `$_SESSION`, invalida la cookie de sesión, destruye la sesión y redirige al login.
- **CSRF:** formularios que cambian datos utilizan un token verificado en PHP.

## Organización del proyecto

```text
ACP Proyecto/
├── index.php / Proyecto.php / Recursos.php / ...  # Sitio público
├── registro.php / login.php / logout.php            # TP8
├── Formulario.php / panel.php                       # TP5 / TP8
├── auth_guard.php                                   # Protector reutilizable
├── admin/
│   ├── index.php / registros.php / editar.php / eliminar.php / usuarios.php
│   └── _guard.php
├── includes/
│   ├── bootstrap.php / auth.php / database.php
│   └── header.php / footer.php / access_denied.php
├── database/
│   ├── schema.sql / consultas.sql
├── docs/
│   ├── NORMALIZACION_TP6.md / CAPTURAS_PARA_ENTREGA.md
├── img/                                               # Fotos originales
├── estilos.css / script.js
├── .env.example / .gitignore / .htaccess
└── README.md
```

## Pruebas para documentar

1. Registrar una cuenta y comprobar que el correo está marcado como único.
2. Comprobar en phpMyAdmin que el campo `password` guarda un hash, no la contraseña original.
3. Iniciar sesión y verificar que se abre `panel.php`.
4. Completar `Formulario.php` y confirmar que aparece la evaluación en la cuenta y en MySQL.
5. Iniciar sesión como administrador y probar búsqueda GET, edición y eliminación.
6. Con un usuario común intentar acceder a `admin/index.php`: debe mostrar acceso denegado.
7. Cerrar sesión y abrir `panel.php`: debe redirigir al login.

La lista detallada para las capturas está en [`docs/CAPTURAS_PARA_ENTREGA.md`](docs/CAPTURAS_PARA_ENTREGA.md). Las evidencias se deben tomar en una instalación funcionando; el ZIP no contiene capturas inventadas.

## Entrega y limitaciones

- Subir el proyecto con su código fuente, imágenes y SQL a GitHub (sin `.env`, dumps con datos personales ni información secreta).
- Documentar cambios con commits reales. Al tratarse de un proyecto PHP y MySQL, **GitHub Pages no puede ejecutarlo**: debe mostrarse en XAMPP u otro hosting con PHP y MySQL.
- El módulo no envía correos, no controla hardware real y no implementa recuperación de contraseña; esas funciones quedan fuera de este alcance.
