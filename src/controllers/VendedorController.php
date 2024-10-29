<?php
class VendedorController {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function registrarVenta($idVendedor, $montoVenta) {
        $sql = "BEGIN registrar_venta(:idVendedor, :montoVenta); END;";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':idVendedor', $idVendedor);
        $stmt->bindParam(':montoVenta', $montoVenta);
        $stmt->execute();
    }
}
