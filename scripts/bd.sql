-- DDL Creacion de la BD
-- Autores: Anderson Fonseca Lopez, Alejandra Guzman, Johan Manuel Colorado

-- Eliminar el tablespace ventas_tbs
-- DROP TABLESPACE VENTAS_TBS INCLUDING CONTENTS AND DATAFILES;

--------------------------------------------------------
--  Crear tablespace Ventas_tbs
--------------------------------------------------------
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
   "ID_AFILIADO" NUMBER NOT NULL,         -- Relaci�n con afiliado
   "USUARIO" VARCHAR2(50) UNIQUE NOT NULL, -- Nombre de usuario �nico
   "CONTRASENA" VARCHAR2(255) NOT NULL,   -- Contrase�a (hashed)
   "FECHA_CREACION" DATE DEFAULT SYSDATE, -- Fecha de creaci�n
   "ULTIMO_ACCESO" DATE,                  -- Fecha del �ltimo acceso
   CONSTRAINT "FK_CUENTA_AFILIADO" FOREIGN KEY ("ID_AFILIADO") 
      REFERENCES "AFILIADO" ("ID_AFILIADO") -- Clave for�nea
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
   "CEDULA" VARCHAR2(20) NOT NULL, -- Nombre obligatorio
   "NOMBRE" VARCHAR2(100) NOT NULL, -- Nombre obligatorio
   "EMAIL" VARCHAR2(100) NOT NULL, -- Email obligatorio
   "TELEFONO" VARCHAR2(20), -- Tel�fono opcional
   "DIRECCION" VARCHAR2(200), -- Direcci�n opcional
   "FECHA_AFILIACION" DATE DEFAULT SYSDATE, -- Fecha con valor predeterminado
   "ESTADO" VARCHAR2(20) DEFAULT 'Activo',
   "NIVEL_HIERARQUIA" NUMBER DEFAULT 1, -- Nivel con valor predeterminado
   "AFILIADO_SUPERIOR_ID" NUMBER, -- Clave for�nea opcional
   CONSTRAINT "UNQ_EMAIL" UNIQUE ("EMAIL"), -- Clave �nica en el correo
   CONSTRAINT "FK_AFILIADO_SUPERIOR" FOREIGN KEY ("AFILIADO_SUPERIOR_ID") REFERENCES "AFILIADO" ("ID_AFILIADO") -- Clave for�nea
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
   "ID_AFILIADO" NUMBER NOT NULL,     -- Clave for�nea hacia la tabla AFILIADO
   "FECHA_VENTA" DATE DEFAULT SYSDATE, -- Fecha de la venta con valor predeterminado
   "TOTAL" NUMBER(10,2) NOT NULL,     -- Monto total de la venta
   CONSTRAINT "FK_VENTA_AFILIADO" FOREIGN KEY ("ID_AFILIADO") 
      REFERENCES "AFILIADO" ("ID_AFILIADO") -- Clave for�nea
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
   "ID_VENTA" NUMBER NOT NULL,       -- Clave for�nea hacia la tabla VENTA
   "ID_AFILIADO" NUMBER NOT NULL,    -- Clave for�nea hacia la tabla AFILIADO
   "NIVEL_HIERARQUIA" NUMBER,        -- Nivel jer�rquico del afiliado
   "MONTO_COMISION" NUMBER(10,2),    -- Monto de la comisi�n
   CONSTRAINT "FK_COMISION_VENTA" FOREIGN KEY ("ID_VENTA") 
      REFERENCES "VENTA" ("ID_VENTA"), -- Clave for�nea a la tabla VENTA
   CONSTRAINT "FK_COMISION_AFILIADO" FOREIGN KEY ("ID_AFILIADO") 
      REFERENCES "AFILIADO" ("ID_AFILIADO") -- Clave for�nea a la tabla AFILIADO
)
SEGMENT CREATION IMMEDIATE
PCTFREE 10 PCTUSED 40 
TABLESPACE "VENTAS_TBS"; -- Usa un tablespace existente o ajusta al necesario

--------------------------------------------------------
--  DDL for Table Configuracion comision
--------------------------------------------------------
CREATE TABLE Configuracion_Comision (
    "ID_CONFIGURACION" NUMBER PRIMARY KEY,
    "NIVEL" NUMBER NOT NULL,
    "PORCENTAJE_COMISION" NUMBER(5, 2) NOT NULL
) TABLESPACE ventas_tbs;

--------------------------------------------------------
--  DDL for Table promocion
--------------------------------------------------------
CREATE TABLE Promocion (
    id_promocion NUMBER PRIMARY KEY,
    id_afiliado NUMBER NOT NULL,
    nivel_promocion NUMBER,
    fecha_promocion DATE DEFAULT SYSDATE,
    CONSTRAINT fk_promocion_afiliado FOREIGN KEY (id_afiliado) REFERENCES Afiliado(id_afiliado)
) TABLESPACE ventas_tbs;

--------------------------------------------------------
--  DDL for Table despacho
--------------------------------------------------------
CREATE TABLE Despacho (
    id_despacho NUMBER PRIMARY KEY,
    id_venta NUMBER NOT NULL,
    estado VARCHAR2(50) DEFAULT 'Pendiente',
    fecha_despacho DATE,
    fecha_entrega DATE,
    CONSTRAINT fk_despacho_venta FOREIGN KEY (id_venta) REFERENCES Venta(id_venta)
) TABLESPACE ventas_tbs;

--------------------------------------------------------
--  Crear tablespace Produco_tbs
--------------------------------------------------------
CREATE TABLESPACE "PRODUCTOS_TBS"
DATAFILE 'productos_tbs.dbf' SIZE 100M AUTOEXTEND ON NEXT 10M MAXSIZE UNLIMITED
LOGGING
EXTENT MANAGEMENT LOCAL
SEGMENT SPACE MANAGEMENT AUTO;

--------------------------------------------------------
--  DDL for Table Producto
--------------------------------------------------------
CREATE TABLE Producto (
    "ID_PRODUCTO" NUMBER PRIMARY KEY,
    "NOMBRE" VARCHAR2(100) NOT NULL,
    "CATEGORIA" VARCHAR2(50),
    "PRECIO" NUMBER(10, 2) NOT NULL,
    "STOCK" NUMBER NOT NULL
) TABLESPACE productos_tbs;


--------------------------------------------------------
--  DDL for Table INVENTARIO
--------------------------------------------------------
CREATE TABLE "INVENTARIO" 
(
    "ID_INVENTARIO" NUMBER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,  -- Generación automática de ID, siempre autoincremental
    "ID_PRODUCTO" NUMBER,                                             -- ID de producto, clave foránea
    "STOCK" NUMBER,                                                   -- Stock del producto
    "FECHA_INGRESO" DATE,                                             -- Fecha de ingreso
    "FECHA_SALIDA" DATE,                                              -- Fecha de salida
    CONSTRAINT "FK_PRODUCTO" FOREIGN KEY ("ID_PRODUCTO")               -- Clave foránea
        REFERENCES "PRODUCTO" ("ID_PRODUCTO")                         -- Referencia a la tabla PRODUCTO
)TABLESPACE productos_tbs;
