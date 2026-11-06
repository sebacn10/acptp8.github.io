-- TP6: consultas demostrativas (ejecutar las de escritura solo con datos de prueba)
USE acp_proyecto;
-- SELECT con JOIN: evaluaciones, autores y estados.
SELECT e.id, u.nombre AS autor, e.nombre_apellido, s.nombre AS estado, e.created_at
FROM evaluaciones e
JOIN usuarios u ON u.id=e.usuario_id
JOIN estados_revision s ON s.id=e.estado_id
ORDER BY e.created_at DESC;

-- SELECT con filtro por usuario (sustituí el número por un ID existente).
SELECT * FROM evaluaciones WHERE usuario_id=1 ORDER BY created_at DESC;

-- Ejemplos de INSERT/UPDATE/DELETE del CRUD, con parámetros en PHP:
-- INSERT INTO evaluaciones (usuario_id,nombre_apellido,correo,opinion_funcionamiento,estado_id) VALUES (?,?,?,?,1);
-- UPDATE evaluaciones SET opinion_funcionamiento=?,estado_id=? WHERE id=?;
-- DELETE FROM evaluaciones WHERE id=?;
