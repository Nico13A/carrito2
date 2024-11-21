<?php
$Titulo = "Code Wear - Manejo de productos";
include_once "../estructura/cabecera.php";

$datos = data_submitted();
$obj = new ABMProducto();
$lista = $obj->buscar(null);
?>

<div class="container d-flex justify-content-between align-items-center py-4">
    <h2 class="display-5 fw-normal text-center m-0 flex-grow-1 text-center">Manejo de productos</h2>
    <?php if ($objSession->validar()) { ?>
        
    <?php } ?>
</div>

<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <input type="button" class="btn btn-primary fw-bold" id="ingresarProducto" value="Ingresar un nuevo producto">
        </div>
    </div>
</div>
<div class="row float-left">
    <div class="col-md-12 float-left">
        <?php if (isset($datos) && isset($datos['msg']) && $datos['msg'] != null) {
            echo $datos['msg'];
        } ?>
    </div>
</div>

<div class="container py-2 mb-4">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php if (count($lista) > 0) {
            foreach ($lista as $objTabla) { ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <img src="<?php echo $URLIMAGEN . $objTabla->getUrlImagen(); ?>" class="card-img-top" alt="<?php echo $objTabla->getProNombre(); ?>">
                        <div class="card-body">
                            <h5 class="card-title text-center"><?php echo $objTabla->getProNombre(); ?></h5>
                            <div class="d-flex gap-2 justify-content-center align-items-center py-4">
                                <span class="fw-bold">Precio: </span>
                                <span class="text-muted">$<?php echo $objTabla->getProPrecio(); ?></span>
                            </div>
                            <?php if ($objSession->validar()) { ?>
                                <div class="d-grid gap-3 d-md-flex justify-content-center">
                                <button class="editarProducto btn" data-id="<?php echo $objTabla->getIdProducto(); ?>">Editar Producto
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </button>
                                <button class="eliminarProducto btn" data-id="<?php echo $objTabla->getIdProducto(); ?>">Eliminar Producto
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </button>


                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php }
        } ?>
    </div>
</div>

<!-- Modal modificar -->
<div class="modal fade" id="productoModal" tabindex="-1" aria-labelledby="productoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productoModalLabel">editar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <h3 id="product-name" class="text-center"></h3>
                <div class="d-flex align-items-center">
                    <img id="product-image" src="" alt="Imagen del producto" class="img-fluid me-3 imagen-producto-modal">
                    <div>
                    <div>
                        <label for="product-details" style="font-weight: bold;">Nombre</label>
                        <textarea name="product-nombre" id="product-nombre" style="width: 100%; height: 60px; resize: none; padding: 5px;"></textarea>
                    </div>
                    <div>
                        <label for="product-details" style="font-weight: bold;">Detalle</label>
                        <textarea name="product-details" id="product-details" style="width: 100%; height: 60px; resize: none; padding: 5px;"></textarea>
                    </div>

                     <div style="display: flex; align-items: center; justify-content: space-between;">
                        <label for="product-price" style="font-weight: bold; margin-right: 10px;">Precio $</label>
                        <input type="number" name="product-price" id="product-price" style="flex: 1; padding: 5px; height: 35px;">
                    </div>


                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <label for="product-stock" style="font-weight: bold; margin-right: 10px;">Stock</label>
                        <input type="number" name="product-stock" id="product-stock" style="flex: 1; padding: 5px; height: 35px;">
                    </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                    <div>
                        <input type="hidden" name="idproducto" id="idproducto" value="">
                    </div>
                    <div>
                        <input type="submit" class="btn btn-success" id="cambiar" value="cambiar">
                    </div>
                
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Eliminar -->
<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="w-100">
                    <h5 class="modal-title" id="eliminarModalPregunta">¿Está seguro de que quiere eliminar este producto?</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <h3 id="product-name" class="text-center"></h3>
                <div class="d-flex align-items-center">
                    <img id="eliminar-image" src="" alt="Imagen del producto" class="img-fluid me-3 imagen-producto-modal">
                    <div>
                        <p id="eliminar-nombre"></p>
                        <p id="eliminar-details"></p>
                        <p id="eliminar-price"></p>
                        <p id="eliminar-stock"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div>
                    <input type="hidden" name="ideliminar" id="ideliminar" value="">
                </div>
                <div>
                    <input type="submit" class="btn btn-success" id="Eliminar" value="Eliminar">
                </div>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Modal para agregar -->
<div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md custom-modal-width">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Columna para la imagen -->
          <div class="col-md-4">
            <!-- Contenedor para previsualización -->
            <div
              id="previsualizador"
              class="border border-secondary rounded mb-3 d-flex justify-content-center align-items-center"
              style="width: 100%; height: 150px; background-color: #f8f9fa; overflow: hidden;">
              <img
                id="imagenPrevisualizada"
                src=""
                alt="Previsualización de la imagen"
                style="max-height: 100%; max-width: 100%; display: none; object-fit: cover;"
              >
            </div>

            <!-- Subir archivo -->
            <form id="subirImagen" enctype="multipart/form-data" class="text-center"> 
              <input
                type="file"
                name="imagenProducto"
                class="form-control mb-2"
                id="imagenProducto"
                accept="image/*">
              <button type="submit" id="subir" class="btn btn-primary btn-sm">Subir Imagen</button>
            </form>
            <div id="contenedorUrl" >
                <input type="hidden" name="urlImagen" id="urlImagen" value="">
            </div>
          </div>

          <!-- Detalles inputs -->
          <div class="col-md-8">
            <div class="mb-2">
              <label for="product-name" class="form-label">Nombre del producto:</label>
              <input type="text" class="form-control" id="nombreProducto">
            </div>
            <div class="mb-2">
              <label for="product-description" class="form-label">Descripción del producto:</label>
              <textarea class="form-control" id="descripcionProducto" rows="2"></textarea>
            </div>
            <div class="mb-2">
              <label for="product-price" class="form-label">Precio:</label>
              <input type="number" class="form-control" id="precioProducto">
            </div>
            <div class="mb-2">
              <label for="product-stock" class="form-label">Cantidad disponible:</label>
              <input type="number" class="form-control" id="cantProducto">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="agregarProducto">Agregar Producto</button>
      </div>
    </div>
  </div>
</div>








<script src="./js/ingresarProducto.js"></script>

<script src="./js/subir.js"></script>

<script src="./js/mostrarIngresarProducto.js"></script>

<script src="./js/eliminarProducto.js"></script>

<script src="./js/confirmacionEliminar.js"></script>

<script src="./js/editarProducto.js"></script>

<script src="./js/guardarCambio.js"></script>

<?php include_once "../estructura/pie.php"; ?>
