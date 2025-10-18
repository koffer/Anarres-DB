CREATE TABLE "alumnos" (
  "id" integer PRIMARY KEY,
  "nombre" varchar NOT NULL,
  "clases_id" integer UNIQUE,
  "salones_id" integer UNIQUE,
  "dormitorios_id" integer UNIQUE,
  "talleres_id" integer UNIQUE,
  "nacimiento_id" integer UNIQUE,
  "trabajo_id" integer UNIQUE
);

CREATE TABLE "clases" (
  "id" integer PRIMARY KEY,
  "titulo" varchar
);

CREATE TABLE "poblacion" (
  "id" integer PRIMARY KEY,
  "nombre" varchar NOT NULL,
  "descripcion" text
);

CREATE TABLE "salones" (
  "id" integer PRIMARY KEY,
  "titulo" varchar NOT NULL,
  "descripcion" text
);

CREATE TABLE "talleres" (
  "id" integer PRIMARY KEY,
  "titulo" varchar NOT NULL,
  "descripcion" text
);

CREATE TABLE "dormitorios" (
  "id" integer PRIMARY KEY,
  "titulo" varchar NOT NULL,
  "descripcion" text,
  "cupo" integer NOT NULL
);

COMMENT ON COLUMN "poblacion"."descripcion" IS 'Descripción del lugar';

COMMENT ON COLUMN "salones"."descripcion" IS 'Descripción del salon';

COMMENT ON COLUMN "talleres"."descripcion" IS 'Descripción del taller';

COMMENT ON COLUMN "dormitorios"."descripcion" IS 'Descripción del dormitorio';

ALTER TABLE "alumnos" ADD FOREIGN KEY ("nacimiento_id") REFERENCES "poblacion" ("id");

ALTER TABLE "alumnos" ADD FOREIGN KEY ("trabajo_id") REFERENCES "poblacion" ("id");

ALTER TABLE "alumnos" ADD FOREIGN KEY ("dormitorios_id") REFERENCES "dormitorios" ("id");

ALTER TABLE "alumnos" ADD FOREIGN KEY ("talleres_id") REFERENCES "talleres" ("id");

ALTER TABLE "alumnos" ADD FOREIGN KEY ("salones_id") REFERENCES "salones" ("id");

ALTER TABLE "alumnos" ADD FOREIGN KEY ("clases_id") REFERENCES "clases" ("id");
