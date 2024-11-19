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

--------------------------------------------------------
--  DDL for Table CUENTA
--------------------------------------------------------
CREATE TABLE "CUENTA" 
(
   "ID_CUENTA" NUMBER PRIMARY KEY,        -- Clave primaria
   "ID_AFILIADO" NUMBER NOT NULL,         -- Relación con afiliado
   "USUARIO" VARCHAR2(50) UNIQUE NOT NULL, -- Nombre de usuario único
   "CONTRASENA" VARCHAR2(255) NOT NULL,   -- Contraseña (hashed)
   "FECHA_CREACION" DATE DEFAULT SYSDATE, -- Fecha de creación
   "ULTIMO_ACCESO" DATE,                  -- Fecha del último acceso
   CONSTRAINT "FK_CUENTA_AFILIADO" FOREIGN KEY ("ID_AFILIADO") 
      REFERENCES "AFILIADO" ("ID_AFILIADO") -- Clave foránea
)
SEGMENT CREATION IMMEDIATE
PCTFREE 10 PCTUSED 40
TABLESPACE "VENTAS_TBS"; -- Usa el tablespace adecuado

--------------------------------------------------------
--  DDL for Table AFILIADO
--------------------------------------------------------
CREATE TABLE "AFILIADO" 
(
   "ID_AFILIADO" NUMBER PRIMARY KEY, -- Clave primaria
   "NOMBRE" VARCHAR2(100) NOT NULL, -- Nombre obligatorio
   "EMAIL" VARCHAR2(100) NOT NULL, -- Email obligatorio
   "TELEFONO" VARCHAR2(20), -- Teléfono opcional
   "DIRECCION" VARCHAR2(200), -- Dirección opcional
   "FECHA_AFILIACION" DATE DEFAULT SYSDATE, -- Fecha con valor predeterminado
   "ESTADO" VARCHAR2(20) DEFAULT 'Activo',
   "NIVEL_HIERARQUIA" NUMBER DEFAULT 1, -- Nivel con valor predeterminado
   "AFILIADO_SUPERIOR_ID" NUMBER, -- Clave foránea opcional
   CONSTRAINT "UNQ_EMAIL" UNIQUE ("EMAIL"), -- Clave única en el correo
   CONSTRAINT "FK_AFILIADO_SUPERIOR" FOREIGN KEY ("AFILIADO_SUPERIOR_ID") REFERENCES "AFILIADO" ("ID_AFILIADO") -- Clave foránea
)
SEGMENT CREATION IMMEDIATE
PCTFREE 10 PCTUSED 40
TABLESPACE "VENTAS_TBS"; -- Usa un tablespace existente

--------------------------------------------------------
--  DDL for Table VENTA
--------------------------------------------------------

CREATE TABLE "VENTA" 
(
   "ID_VENTA" NUMBER PRIMARY KEY,     -- Clave primaria
   "ID_AFILIADO" NUMBER NOT NULL,     -- Clave foránea hacia la tabla AFILIADO
   "FECHA_VENTA" DATE DEFAULT SYSDATE, -- Fecha de la venta con valor predeterminado
   "TOTAL" NUMBER(10,2) NOT NULL,     -- Monto total de la venta
   CONSTRAINT "FK_VENTA_AFILIADO" FOREIGN KEY ("ID_AFILIADO") 
      REFERENCES "AFILIADO" ("ID_AFILIADO") -- Clave foránea
)
SEGMENT CREATION IMMEDIATE
PCTFREE 10 PCTUSED 40 
TABLESPACE "VENTAS_TBS"; -- Usa un tablespace existente o ajusta al necesario


--------------------------------------------------------
--  DDL for Table COMISION
--------------------------------------------------------
CREATE TABLE "COMISION" 
(
   "ID_COMISION" NUMBER PRIMARY KEY, -- Clave primaria
   "ID_VENTA" NUMBER NOT NULL,       -- Clave foránea hacia la tabla VENTA
   "ID_AFILIADO" NUMBER NOT NULL,    -- Clave foránea hacia la tabla AFILIADO
   "NIVEL_HIERARQUIA" NUMBER,        -- Nivel jerárquico del afiliado
   "MONTO_COMISION" NUMBER(10,2),    -- Monto de la comisión
   CONSTRAINT "FK_COMISION_VENTA" FOREIGN KEY ("ID_VENTA") 
      REFERENCES "VENTA" ("ID_VENTA"), -- Clave foránea a la tabla VENTA
   CONSTRAINT "FK_COMISION_AFILIADO" FOREIGN KEY ("ID_AFILIADO") 
      REFERENCES "AFILIADO" ("ID_AFILIADO") -- Clave foránea a la tabla AFILIADO
)
SEGMENT CREATION IMMEDIATE
PCTFREE 10 PCTUSED 40 
TABLESPACE "VENTAS_TBS"; -- Usa un tablespace existente o ajusta al necesario




