-- Sentencias INSERT para la tabla "clases"
-- ¡Adiós POO, hola Plomería!

INSERT INTO "clases" ("titulo", "descripcion") VALUES
('Agricultura', 'Técnicas de siembra, cosecha y gestión de suelos orgánicos.'),
('Carpintería', 'Introducción al trabajo con madera, desde la medición y corte hasta el ensamblaje de muebles básicos.'),
('Recuperación de Aguas Servidas', 'Métodos de tratamiento y reutilización de aguas residuales a pequeña y mediana escala.'),
('Imprenta', 'Introducción a la tipografía, grabado y el manejo de prensas manuales y digitales.'),
('Plomería', 'Instalación, mantenimiento y reparación de sistemas de tuberías y desagües.'),
('Reparación de Caminos', 'Clase práctica sobre la nivelación, compactación y pavimentación de caminos rurales.'),
('Dramaturgia', 'Escritura creativa de guiones y obras de teatro, enfocada en la estructura narrativa y el diálogo.');



-- Sentencias INSERT para la tabla "salones"
-- Títulos actualizados: Hed, tuk, fiu, Hed, hek

INSERT INTO "salones" ("titulo", "descripcion") VALUES
('Hed', 'Aula magna con capacidad para 50 estudiantes, equipada con proyectores duales.'),
('tuk', 'Espacio mediano ideal para grupos de 30, con pizarrón.'),
('fiu', 'Aula pequeña para tutorías o grupos de 15, con excelente iluminación natural.'),
('Hed', 'Salón de conferencias adaptable para 60 personas con sistema de audio.'),
('hek', 'Nuevo espacio modular flexible, ideal para demostraciones prácticas.');


-- Sentencias INSERT para la tabla "talleres"
-- Títulos actualizados: Orfebrería, Mecánica, Agricultura.

INSERT INTO "talleres" ("titulo", "descripcion") VALUES
('Orfebrería', 'Espacio equipado para el trabajo de metales preciosos, incluyendo fundición, laminado y pulido.'),
('Mecánica', 'Área de trabajo para la reparación de motores pequeños y maquinaria, con herramientas manuales y eléctricas.'),
('Agricultura', 'Invernadero y espacio al aire libre dedicado a la experimentación con técnicas agrícolas avanzadas.');


-- 1. Insert para "poblacion" (Nacimiento y Trabajo)
INSERT INTO "poblacion" ("nombre", "descripcion") VALUES
('La Polvareda', 'Una población mineras en el interior, hacia el oeste, y hasta las dilatadas planicies del sudeste, donde se extendía un territorio deshabitado.'),
('Nio Esseia', 'Ciudad de la luna Anarres');

-- 2. Insert para "dormitorios"
INSERT INTO "dormitorios" ("titulo", "descripcion", "cupo") VALUES
('Residencia Central', 'Dormitorio principal para todos los alumnos', 10),
('Residencia No central', 'Segundo dormitorio para todos los alumnos', 10);


-- 3. Insert para "alumnos" (usando ID 1, 2, 1 para las FKs)
INSERT INTO "alumnos" ("nombre", "descripcion", "dormitorios_id", "nacimiento_id", "trabajo_id") VALUES
('Palenka', 'Alumno con interés en construcción.', 1, 1, 1),
('Shevrena', 'Estudiante de artes manuales.', 2, 1, 1),
('irrenk', 'Enfocado en oficios técnicos.', 1, 1, 2),
('Eveack', 'Interesado en la sostenibilidad.', 2, 2, 1),
('AurGar', 'Futuro dramaturgo y editor.', 2, 1, 2),
('irranack', 'Apasionado por la mecánica y la reparación.', 1, 1, 2),
('EvTek', 'Conocimientos previos en electrónica.', 3,2, 2),
('irranar', 'Experto en el uso de herramientas pesadas.', 3, 1, 2),
('hevraler', 'Busca mejorar la infraestructura local.', 2, 2, 2),
('Gibres', 'Creativo y con habilidades de diseño.', 1, 1, 2);


-- 4. Insert para "alumnos_clases" (Asignación de 2-3 Clases por Alumno)

INSERT INTO "alumnos_clases" ("alumnos_id", "clases_id") VALUES
-- Palenka (ID 1): 3 Clases
(1, 2), -- Carpintería
(1, 5), -- Plomería
(1, 6), -- Reparación de Caminos

-- Shevrena (ID 2): 3 Clases
(2, 4), -- Imprenta
(2, 7), -- Dramaturgia
(2, 2), -- Carpintería

-- irrenk (ID 3): 2 Clases
(3, 5), -- Plomería
(3, 6), -- Reparación de Caminos

-- Eveack (ID 4): 3 Clases
(4, 1), -- Agricultura
(4, 3), -- Recuperación de Aguas Servidas
(4, 5), -- Plomería

-- AurGar (ID 5): 2 Clases
(5, 4), -- Imprenta
(5, 7), -- Dramaturgia

-- irranack (ID 6): 3 Clases
(6, 6), -- Reparación de Caminos
(6, 5), -- Plomería
(6, 2), -- Carpintería

-- EvTek (ID 7): 2 Clases
(7, 3), -- Recuperación de Aguas Servidas
(7, 1), -- Agricultura

-- irranar (ID 8): 3 Clases
(8, 2), -- Carpintería
(8, 6), -- Reparación de Caminos
(8, 5), -- Plomería

-- hevraler (ID 9): 2 Clases
(9, 6), -- Reparación de Caminos
(9, 3), -- Recuperación de Aguas Servidas

-- Gibres (ID 10): 3 Clases
(10, 7), -- Dramaturgia
(10, 4), -- Imprenta
(10, 1); -- Agricultura


-- Asignación de clases teóricas a Salones (Hed, tuk, fiu, hek)
INSERT INTO "clases_salones" ("clases_id", "salones_id") VALUES
-- Clases puramente teóricas
(7, 3), -- Dramaturgia en fiu
(4, 2), -- Imprenta (teoría) en tuk
(3, 1), -- Rec. Aguas Servidas (teoría) en Hed (1)

-- Clases con más de un salón
(1, 4), -- Agricultura (teoría) en Hed (2)
(1, 5), -- Agricultura (teoría) en hek
(5, 2), -- Plomería (teoría) en tuk
(6, 4); -- Rep. Caminos (teoría) en Hed (2)


-- Asignación de clases prácticas a Talleres (Orfebrería, Mecánica, Agricultura)
INSERT INTO "clases_talleres" ("clases_id", "talleres_id") VALUES
(2, 2), -- Carpintería en Taller de Mecánica (asumiendo que tiene herramientas básicas)
(5, 2), -- Plomería en Taller de Mecánica
(6, 2), -- Rep. Caminos en Taller de Mecánica
(1, 3), -- Agricultura en Taller de Agricultura
(3, 3), -- Rec. Aguas Servidas en Taller de Agricultura

-- Asignación especial (asumimos que Imprenta usa el Taller de Orfebrería por el trabajo manual)
(4, 1); -- Imprenta en Taller de Orfebrería


SELECT
    A.nombre AS "Alumno",
    N.nombre AS "Lugar de Nacimiento",
    W.nombre AS "Lugar de Trabajo",
    C.titulo AS "Clase",
    COALESCE(S.titulo, 'N/A') AS "Salón Asignado (Teoría)",
    COALESCE(T.titulo, 'N/A') AS "Taller Asignado (Práctica)"
FROM
    alumnos AS A
-- 1. Nuevas Uniones a Población:
JOIN
    poblacion AS N ON A.nacimiento_id = N.id  -- Alias N para Nacimiento
JOIN
    poblacion AS W ON A.trabajo_id = W.id    -- Alias W para Trabajo
-- 2. El resto de Uniones se mantienen:
JOIN
    alumnos_clases AS AC ON A.id = AC.alumnos_id
JOIN
    clases AS C ON AC.clases_id = C.id
LEFT JOIN
    clases_salones AS CS ON C.id = CS.clases_id
LEFT JOIN
    salones AS S ON CS.salones_id = S.id
LEFT JOIN
    clases_talleres AS CT ON C.id = CT.clases_id
LEFT JOIN
    talleres AS T ON CT.talleres_id = T.id
ORDER BY
    A.nombre, C.titulo;