<?php $__env->startSection('contenido'); ?>
<div class="row">
    <div class="col-md-3">
        <h3>Nueva Venta</h3>
        <?php if(count($errors)>0): ?>
        <div class="alert alert-danger">
            <ul>
            <?php foreach($errors->all() as $error): ?>
                <li>
                    <?php echo e($error); ?>

                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>       
        <?php echo Form::open(array('url'=>'ventas/venta','method'=>'POST','autocomplete'=>'off')); ?>

        <?php echo e(Form::token()); ?>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="proveeclientedor">Cliente</label>
                    <select name="idcliente" id="idcliente" class="form-control">                        
                        <?php foreach($personas as $persona): ?>
                        <option value="<?php echo e($persona->idpersona); ?>">
                            <?php echo e($persona->nombre); ?>

                        </option>
                        <?php endforeach; ?>  
                    </select>
                </div>
            </div>
           
            <div class="col-md-3">
                <div class="form-group">
                    <label>Comprobante</label>
                    <select name="tipo_comprobante" class="form-control">                        
                        <option value="Boleta">Boleta</option>
                        <option value="Factura">Factura</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="serie_comprobante">Serie Comprobante</label>
                    <input type="text" name="serie_comprobante" value="<?php echo e(old('serie_comprobante')); ?>" class="form-control" placeholder="Serie de comprobante..."/>                
                </div>                
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="num_comprobante">Número Comprobante</label>
                    <input type="text" name="num_comprobante" value="<?php echo e(old('num_comprobante')); ?>" class="form-control" placeholder="Número de comprobante..."/>                
                </div>                
            </div>
        </div>
        <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Artículo</label>
                            <select name="pidarticulo" class="form-control" id="pidarticulo">
                                <?php foreach($articulos as $articulo): ?>
                                <option value="<?php echo e($articulo->idarticulo); ?>_<?php echo e($articulo->stock); ?>_<?php echo e($articulo->precio_promedio); ?>">
                                    <?php echo e($articulo->articulo); ?>

                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>                        
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="pcantidad">Cantidad</label>
                            <input type="number" name="pcantidad" id="pcantidad" class="form-control" placeholder="Cantidad"/>                
                        </div>
                    </div>
                     <div class="col-md-2">
                        <div class="form-group">
                            <label for="pstock">Stock</label>
                            <input type="number" name="pstock" id="pstock" class="form-control" placeholder="Stock" disabled />                
                        </div>
                    </div>
                  
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="precio_venta">Precio Venta</label>
                            <input type="number" name="pprecio_venta" id="pprecio_venta" class="form-control" placeholder="Precio Venta" disabled /> 
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="form-group">
                            <label for="pdescuento">Descuento</label>
                            <input type="number" name="pdescuento" id="pdescuento" class="form-control" placeholder="Descuento"/> 
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">                            
                            <button type="button" name="bt_add" id="bt_add" class="btn btn-primary">
                                Agregar
                            </button> 
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                            <thead style="background-color: #A9D0F5;">
                                <th>Opciones</th>
                                <th>Artículo</th>
                                <th>Cantidad</th>
                                <th>Precio Venta</th>
                                <th>Descuento</th>
                                <th>Subtotal</th>
                            </thead>
                            <tfoot>
                                <th>TOTAL</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                    <h4 id="total">S/. 0.00</h4>
                                    <input type="hidden" name="total_venta" id="total_venta">
                                </th>
                            </tfoot>
                        </table>
                    </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">
                <div class="form-group">
                    <input name="_token" value="<?php echo e(csrf_token()); ?>" type="hidden"/>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <button class="btn btn-danger" type="reset">Cancelar</button>
                </div>
            </div>
        </div>        
        
        
        <?php echo Form::close(); ?>


<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
  

    $(document).ready(function(){
       $("#bt_add").click(function(){
            agregar();
       });
    });

    var cont=0;
    var total=0;
    var subtotal=[];
    $("#guardar").hide();
    $("#pidarticulo").change(mostrarValores);

    function mostrarValores(){
        datosArticulo = document.getElementById('pidarticulo').value.split('_');
        $('#pprecio_venta').val(datosArticulo[2]);
        $('#pstock').val(datosArticulo[1]);
    }
    
    function agregar(){
        datosArticulo = document.getElementById('pidarticulo').value.split('_');

        idarticulo = datosArticulo[0];
        articulo = $("#pidarticulo option:selected").text();
        cantidad = $("#pcantidad").val();
        descuento = $("#pdescuento").val();
        precio_venta = $("#pprecio_venta").val();
        stock = $("#pstock").val();
        
        if(idarticulo!="" && cantidad!="" && cantidad>0 && descuento!="" && precio_venta!=""){
            if(stock>=cantidad){
                subtotal[cont] = (cantidad*precio_venta-descuento);
                total = total+subtotal[cont];
                
                var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">x</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input type="number" name="precio_venta[]" value="'+precio_venta+'"></td><td><input type="number" name="descuento[]" value="'+descuento+'"></td><td>'+subtotal[cont]+'</td></tr>';
                cont++;
                limpiar();
                $("#total").html("S/. "+total);
                $("#total_venta").val(total);

                evaluar();
                $('#detalles').append(fila);
            }else{
                alert("la cantidad a vender supera el stock");
            }

            
        }else{
            alert("Error al ingresar el detalle de la venta, revise los datos del articulo");
        }
    }
    
    function limpiar(){
        $("#pcantidad").val("");
        $("#pdescuento").val("");
        $("#pprecio_venta").val("");
    }
    function evaluar(){
        if(total>0){
            $("#guardar").show();
        }else{
            $("#guardar").hide();
        }
    }
    function eliminar(index){
        total = total-subtotal[index];
        $("#total").html("S/."+total);
        $("#total_venta").val(total);
        $("#fila"+index).remove();
        evaluar();
    }

</script>

<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>