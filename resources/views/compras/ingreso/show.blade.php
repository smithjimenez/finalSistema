@extends('layouts.admin')
@section('contenido') 
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="proveedor">Proveedor</label>
                    <input type="text" class="form-control" placeholder="{{$ingreso->nombre}}" disabled>
                </div>
            </div>
           
            <div class="col-md-4">
                <div class="form-group">
                    <label>Serie Comprobante</label>
                    <input type="text" class="form-control" placeholder="{{$ingreso->serie_comprobante}}" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="num_comprobante">Número Comprobante</label>
                    <input type="text" class="form-control" placeholder="{{$ingreso->num_comprobante}}" disabled>
                </div>                
            </div>
           
        </div>
        <div class="row">                  
                    <div class="col-md-12">
                        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                            <thead style="background-color: #A9D0F5;">                                
                                <th>Artículos</th>
                                <th>Cantidad</th>
                                <th>Precio Compra</th>
                                <th>Precio Venta</th>
                                <th>Subtotal</th>
                            </thead>
                            <tfoot>                                
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><h4 id="total">{{$ingreso->total}}</h4></th>
                            </tfoot>
                            <tbody>
                                @foreach($detalles as $det)
                                <tr>
                                    <td>{{$det->articulo}}</td>
                                    <td>{{$det->cantidad}}</td>
                                    <td>{{$det->precio_compra}}</td>
                                    <td>{{$det->precio_venta}}</td>
                                    <td>{{$det->cantidad*$det->precio_compra}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> 
        </div>        
        
@endsection