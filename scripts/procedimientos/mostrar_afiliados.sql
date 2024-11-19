CREATE OR REPLACE PROCEDURE MOSTRAR_AFILIADOS(
 c_afiliados OUT SYS_REFCURSOR
)
AS
BEGIN
    OPEN c_afiliados FOR
        SELECT 
            ID_AFILIADO,
            NOMBRE,
            EMAIL,
            TELEFONO,
            DIRECCION,
            FECHA_AFILIACION,
            ESTADO,
            NIVEL_HIERARQUIA,
            AFILIADO_SUPERIOR_ID,
            CEDULA
        FROM 
            AFILIADO;
END;
/
