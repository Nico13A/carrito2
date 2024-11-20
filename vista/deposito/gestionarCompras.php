<?php
$Titulo = "Code Wear - Control Compras";

include_once "../estructura/cabecera.php";
$datos = data_submitted();

$obj = new ABMCompraEstado();
$lista = $obj->buscar(null); // Esto debería retornar los datos de la tabla CompraEstado
?>

<div class="row float-left">
    <div class="col-md-12 float-left">
    <?php 
        if (isset($datos) && isset($datos['msg']) && $datos['msg'] != null) {
            echo $datos['msg'];
        }
    ?>
    </div>
</div>

<h2 class="display-5 fw-normal text-center py-4">Control de compras</h2>
<div class="container py-2 mb-4 contenedorTabla">
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th class="align-middle" scope="col">ID Compra</th>
                <th class="align-middle" scope="col">Estado</th>
                <th class="align-middle" scope="col">Fecha Inicio</th>
                <th class="align-middle" scope="col">Fecha Fin</th>
                <th class="align-middle" scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($lista) {
                foreach ($lista as $estadoCompra) {
                    echo "<tr>";
                    echo "<td class='align-middle'>" . $estadoCompra->getObjCompra()->getIdCompra() . "</td>";
                    echo "<td class='align-middle'>" . $estadoCompra->getObjCompraEstadoTipo()->getCetDescripcion() . "</td>";
                    echo "<td class='align-middle'>" . $estadoCompra->getCefechaini() . "</td>";
                    echo "<td class='align-middle'>" . $estadoCompra->getCefechafin() . "</td>";
                    echo "<td class='align-middle'>";
                    echo "<button class='btn btn-secondary me-3 btnModificar' data-idcompraestado='" . $estadoCompra->getIdCompraEstado() . "'>Modificar</button>";
                    echo "</td>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No hay registros de estado de compras</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="modalModificar" tabindex="-1" aria-labelledby="modalModificarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalModificarLabel">Modificar Estado de Compra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formModificarEstadoCompra">
                    <div class="mb-3">
                        <label for="cetdescripcion" class="form-label">Selecciona una opción</label>
                        <select class="form-select" id="cetdescripcion" required>
                        <option value="aceptada">Aceptar</option>
                        <option value="cancelada">Cancelar</option>
                        <option value="enviada">Enviar</option>
                        </select>
                    </div>
                    <input type="hidden" id="idcompraEstado" name="idcompraestado">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="./js/modificarEstadoCompra.js"></script>

<?php
include_once "../estructura/pie.php";
?>
