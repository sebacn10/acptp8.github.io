# TP6 — Normalización de datos del Proyecto ACP

## Situación inicial
El sitio original incluía páginas HTML de un **techo corredizo automatizado con Arduino** y formularios visuales. No había tablas relacionadas, por lo que no existían usuarios autenticados ni evaluaciones persistidas.

## Entidades y dependencias

- **usuarios:** `id` determina `nombre`, `email`, `password`, `rol` y `created_at`. El correo es único. La contraseña se guarda mediante hash.
- **estados_revision:** `id` determina `nombre`. Son los valores maestros de estado (Pendiente, Revisado, Resuelto).
- **evaluaciones:** `id` determina `usuario_id`, `nombre_apellido`, `correo`, `opinion_funcionamiento`, `estado_id` y `created_at`.

## Primera forma normal (1FN)
Cada columna contiene un único valor atómico y cada fila se identifica con una clave primaria. No se guardan conjuntos de estados ni observaciones concatenadas en columnas.

## Segunda forma normal (2FN)
Las tablas tienen claves primarias simples (`id`). Todos los atributos no clave dependen de la clave completa; no hay dependencias parciales.

## Tercera forma normal (3FN)
Los nombres de los estados se administran en `estados_revision` y se referencian mediante `estado_id`. La información de la cuenta se almacena en `usuarios`, mientras que las evaluaciones se relacionan con ella mediante `usuario_id`. De esta manera se evita duplicar roles, contraseñas y nombres de estado en cada evaluación.

**Nota sobre los datos de evaluación:** `nombre_apellido` y `correo` en `evaluaciones` registran los datos de contacto declarados *para esa evaluación*. Pueden diferir del nombre y correo de la cuenta; por eso se conservan como información propia de la observación y no son copias de columnas de `usuarios`.

## Relaciones

```text
usuarios (1) -------- (N) evaluaciones (N) -------- (1) estados_revision
   id                       usuario_id, estado_id                 id
```

## Restricciones y consultas
El SQL define claves primarias auto-incrementales, claves foráneas, índice único de correo e índices para usuario, estado y fecha. Consultas de demostración en `database/consultas.sql`.

No se creó relación muchos-a-muchos porque **el caso de uso actual no la requiere**. Se podrá agregar cuando exista una necesidad funcional real.
