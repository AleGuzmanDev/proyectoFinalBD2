-- DDL Creacion de la BD
-- 18/11/2024
-- Autores: Anderson Fonseca Lopez, Alejandra Guzman, Johan Manuel Colorado

-- Eliminar el tablespace ventas_tbs
-- DROP TABLESPACE VENTAS_TBS INCLUDING CONTENTS AND DATAFILES;

-- Crear el table space del afiliado
CREATE TABLESPACE "VENTAS_TBS"
DATAFILE 'ventas_tbs.dbf' SIZE 100M AUTOEXTEND ON NEXT 10M MAXSIZE UNLIMITED
LOGGING
EXTENT MANAGEMENT LOCAL
SEGMENT SPACE MANAGEMENT AUTO;

-- Crear tabla afiliado
CREATE TABLE "AFILIADO" 
(
   "ID_AFILIADO" NUMBER PRIMARY KEY, -- Clave primaria
   "NOMBRE" VARCHAR2(100) NOT NULL, -- Nombre obligatorio
   "EMAIL" VARCHAR2(100) NOT NULL, -- Email obligatorio
   "TELEFONO" VARCHAR2(20), -- Tel�fono opcional
   "DIRECCION" VARCHAR2(200), -- Direcci�n opcional
   "FECHA_AFILIACION" DATE DEFAULT SYSDATE, -- Fecha con valor predeterminado
   "ESTADO" VARCHAR2(20) DEFAULT 'Activo' CHECK ("ESTADO" IN ('Activo', 'Inactivo', 'Suspendido')), -- Restricci�n CHECK
   "NIVEL_HIERARQUIA" NUMBER DEFAULT 1, -- Nivel con valor predeterminado
   "AFILIADO_SUPERIOR_ID" NUMBER, -- Clave for�nea opcional
   CONSTRAINT "UNQ_EMAIL" UNIQUE ("EMAIL"), -- Clave �nica en el correo
   CONSTRAINT "FK_AFILIADO_SUPERIOR" FOREIGN KEY ("AFILIADO_SUPERIOR_ID") REFERENCES "AFILIADO" ("ID_AFILIADO") -- Clave for�nea
)
SEGMENT CREATION IMMEDIATE
PCTFREE 10 PCTUSED 40
TABLESPACE "VENTAS_TBS"; -- Usa un tablespace existente



