## TP8 — Registro, login, sesiones y roles

Se añadió autenticación y manejo del estado del usuario a través de sesiones PHP:

- **Registro (`registro.php`):** validación, comprobación de correo repetido y contraseña almacenada con `password_hash()`.
- **Login (`login.php`):** verificación con `password_verify()` y regeneración del identificador mediante `session_regenerate_id(true)`.
- **Sesión:** uso de `$_SESSION` para identificar al usuario y mantener el acceso entre páginas.
- **Protección de rutas (`auth_guard.php` y `includes/auth.php`):** redirección al login cuando no existe una sesión válida.
- **Roles (`admin/_guard.php`):** solo usuarios con rol administrador acceden a las operaciones protegidas.
- **Logout (`logout.php`):** vaciado de variables de sesión, invalidación de cookie y `session_destroy()`.

**Registro de usuario:**

![Registro de cuenta del TP8](capturas%20tp8/tp8-registro.png)

**Inicio de sesión:**

![Pantalla de login del TP8](capturas%20tp8/tp8-login.png)

**Panel con sesión iniciada:**

![Panel de usuario del TP8](capturas%20tp8/tp8-panel.png)

**Restricción de acceso por roles:**

![Prueba de roles del TP8](capturas%20tp8/tp8-roles.png)

**Cierre de sesión:**

![Prueba de logout del TP8](capturas%20tp8/tp8-logout.png)

## Instalación local con XAMPP

1. Activar **Apache** y **MySQL** en XAMPP.
2. Copiar la carpeta del proyecto a `C:\xampp\htdocs\ACP Proyecto\`.
3. Importar `database/schema.sql` desde **phpMyAdmin** para crear `acp_proyecto`.
4. Copiar `.env.example` a `.env` y ajustar las credenciales **solo en la PC local**.
5. Abrir `http://localhost/ACP%20Proyecto/index.php`.
6. Crear una cuenta desde `registro.php`, iniciar sesión en `login.php` y probar las páginas protegidas.

La base `acp_proyecto` es independiente de la base `lunarmc`.

## Organización del repositorio y evidencias

El `README.md` y las carpetas de capturas deben estar **al mismo nivel (en la raíz del repositorio)**:

```text
README.md
capturas tp4/
  tp4-inicio.png
  tp4-inlcudes.png
capturas tp5/
  tp5-get.png
  tp5-post.png
capturas tp6/
  tp6-consultas sql.png
  tp6-sql.png
  tp6-tablas.png
capturas tp7/
  tp7-delete.png
  tp7-read.png
  tp7-update.png
capturas tp8/
  tp8-login.png
  tp8-logout.png
  tp8-panel.png
  tp8-registro.png
  tp8-roles.png
```

> Los nombres de las imágenes anteriores se mantienen **exactamente como están en el ZIP original**, incluido `tp4-inlcudes.png`. Si cambiás algún nombre, también tendrás que actualizar la ruta de su imagen en este README.

## Seguridad y entrega

- No subir a un repositorio público el archivo `.env`, contraseñas, datos personales de cuentas ni respaldos completos con información privada.
- Mostrar **commits reales** con las mejoras realizadas en cada etapa, tal como pide la consigna.
- El proyecto se ejecuta localmente mediante XAMPP. **GitHub Pages no ejecuta PHP ni MySQL**: el repositorio contiene el código y la documentación, no una versión funcional del backend.
- Las imágenes adjuntas son evidencias aportadas para la entrega y deben revisarse antes de hacer público el repositorio para ocultar información personal si corresponde.

## Conclusión

Durante los TP4 al TP8, ACP Proyecto pasó de ser un sitio informativo a una aplicación web con estructura PHP reutilizable, formularios que procesan datos, una base relacional, CRUD administrativo y control de acceso mediante cuentas y sesiones. El trabajo permite aplicar en un mismo proyecto los contenidos desarrollados en Programación Web.
