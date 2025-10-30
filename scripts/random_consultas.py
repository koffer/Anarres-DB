import random

# --- CONFIGURACIÓN ---
# Lista de nombres a utilizar
NOMBRES_ALUMNOS = [
    "Palen ka",
    "Shevrena bue",
    "irrenk orr",
    "irrenk gue",
    "Eve ack",
    "Aur Gar",
    "irran ack",
    "Eve Tek",
    "irran are",
    "hevrak ler"
]

NUM_ALUMNOS = len(NOMBRES_ALUMNOS) # El número de alumnos es el tamaño de la lista
# Rangos de ID válidos (ajusta estos si tus datos base han cambiado)
ID_CLASES_RANGO = (1, 3)     # IDs de clases existentes: 1, 2, 3
ID_DORMITORIOS_RANGO = (1, 2) # IDs de dormitorios existentes: 1, 2
ID_POBLACION_RANGO = (1, 2)  # IDs de población/lugar existentes: 1, 2
# ---------------------

# Palabras para descripciones aleatorias (simulando la funcionalidad de Faker.sentence())
DESCRIPCIONES_PALABRAS = [
    "enfocado", "tecnología", "innovación", "arte", "historia", 
    "futuro", "diseño", "investigación", "análisis", "curioso",
    "dedicado", "programación", "escritura", "cerámica", "matemáticas"
]

def generar_descripcion_aleatoria():
    """Genera una descripción simple seleccionando palabras al azar."""
    num_palabras = random.randint(5, 10)
    # Selecciona palabras al azar y únelas en una frase
    descripcion = ' '.join(random.sample(DESCRIPCIONES_PALABRAS, num_palabras)).capitalize() + '.'
    return descripcion

def generar_datos_alumnos():
    """Genera sentencias INSERT para la tabla 'alumnos' usando la lista de nombres fijos."""
    inserts_alumnos = []
    
    # Usamos enumerate para obtener un índice (que simula el ID) y el nombre
    for i, nombre_alumno in enumerate(NOMBRES_ALUMNOS):
        # El ID que usará la tabla de relación es i + 1
        
        # Generar datos aleatorios
        descripcion_alumno = generar_descripcion_aleatoria()
        
        # Seleccionar IDs de clave foránea de forma aleatoria
        clases_id = random.randint(*ID_CLASES_RANGO)
        dormitorios_id = random.randint(*ID_DORMITORIOS_RANGO)
        nacimiento_id = random.randint(*ID_POBLACION_RANGO)
        trabajo_id = random.randint(*ID_POBLACION_RANGO)
        
        # Sentencia INSERT
        # Nota: Usamos una "sentencia" por alumno para que los IDs se generen secuencialmente
        sql = f"""INSERT INTO "alumnos" ("nombre", "descripcion", "clases_id", "dormitorios_id", "nacimiento_id", "trabajo_id") VALUES
('{nombre_alumno}', '{descripcion_alumno}', {clases_id}, {dormitorios_id}, {nacimiento_id}, {trabajo_id});"""
        
        inserts_alumnos.append(sql)
        
    return inserts_alumnos

def generar_datos_alumnos_clases(max_clases_por_alumno=3):
    """Genera sentencias INSERT para la tabla de relación 'alumnos_clases'."""
    inserts_relaciones = []
    
    # Lista de todos los IDs de clases disponibles para la asignación
    clases_disponibles = list(range(ID_CLASES_RANGO[0], ID_CLASES_RANGO[1] + 1))
    
    for alumno_id in range(1, NUM_ALUMNOS + 1):
        # Elige un número aleatorio de clases para inscribir al alumno
        num_clases_a_tomar = random.randint(1, max_clases_por_alumno)
        
        # Selecciona aleatoriamente las clases (sin reemplazo)
        clases_seleccionadas = random.sample(clases_disponibles, min(num_clases_a_tomar, len(clases_disponibles)))
        
        # Generar los INSERT para la tabla de relación
        for clase_id in clases_seleccionadas:
            sql = f'INSERT INTO "alumnos_clases" ("clases_id", "alumnos_id") VALUES ({clase_id}, {alumno_id});'
            inserts_relaciones.append(sql)
            
    return inserts_relaciones

# --- EJECUCIÓN DEL SCRIPT ---
print(f'-- Generando {NUM_ALUMNOS} alumnos con nombres fijos y sus relaciones...')
print('\n-- INSERTS para la tabla "alumnos"')
print('\n'.join(generar_datos_alumnos()))

print('\n-- INSERTS para la tabla de relación "alumnos_clases"')
print('\n'.join(generar_datos_alumnos_clases()))