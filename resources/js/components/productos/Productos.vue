<template>

    <div class="seccion-catalogo card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    Productos
                </div>
                <div class="col-md-2">
                    <button @click="AbrirModal()" class="btn btn-primary btn-block">Agregar Nuevo +</button>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr  :key="index" v-for="(producto,index) of Productos" >
                                <td>{{ producto.id }}</td>
                                <td>{{ producto.Nombre }}</td>
                                <td>{{ producto.Descripsion }}</td>
                                <td>{{ producto.Precio }}</td>
                                <td>
                                    <button class="btn btn-dark btn-sm">Inventario</button>
                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <modal-template
            IdModal = "modal_producto"
            titulo = "Nuevo"
            size = "modal-lg"
            esnuevo = "true"
        >

            <template slot="formulario">

                <h4>Datos de el Producto</h4>
                
                <br>

                <div class="form-group row">
                    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Nombre</label>
                    <div class="col-sm-10">
                        <input v-model="Producto.Nombre" type="text" class="form-control" placeholder="Ingrese nombre de el producto">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Descripsion</label>
                    <div class="col-sm-10">
                        <textarea rows="5" v-model="Producto.Descripsion" class="form-control" placeholder="Escriba la definicion de el producto">
                        </textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Precio</label>
                    <div class="col-sm-10">
                        <input v-model="Producto.Precio" type="number" class="form-control" placeholder="Ingrese el precio de el producto">
                    </div>
                </div>

                <div v-if="!TieneTallas" class="form-group row">
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Stock</label>
                        <div  class="col-sm-10">
                            <input  type="text" class="form-control" placeholder="Ingrese el stock de el producto">
                        </div>
                </div>

                <div class="form-group row">
                    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Tienes tallas</label>
                    <div  class="col-sm-10">
                        <input v-model="TieneTallas"  type="checkbox">
                        Si
                    </div>
                </div>

                <div v-if="TieneTallas">

                    <h4>Detalles de el producto</h4>
                
                    <br>

                    <div class="form-group row">
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Nombre de la talla</label>
                        <div class="col-sm-10">
                            <input v-model="Talla" class="form-control" type="text">
                        </div>
                    </div>

                    <br>

                    <h5>Talla unitaria</h5>

                    <br>

                    <div class="form-group row">
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Talla</label>
                        <div class="col-sm-10">
                            <input  v-model="DetalleUnitario.Talla" class="form-control" placeholder="Ejemplo: Grande, Chica, Mediana, LG, XL, SM" type="text">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Stock</label>
                        <div class="col-sm-10">
                            <input v-model="DetalleUnitario.Stock"  class="form-control" type="number" placeholder="Ingrese el stock">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Precio adicional</label>
                        <div class="col-sm-10">
                            <input v-model="DetalleUnitario.PrecioAdicional" class="form-control" type="number" placeholder="Ingrese precio adicional">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-10">
                             <button @click="AgregarTalla()" class="btn btn-primary">Agregar</button>
                        </div>
                    </div>


                    <br>

                    <h5>Tabla de tallas</h5>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-sm table-hover">
                                <thead class="thead-dark">
                                    <th>Talla</th>
                                    <th>Stock</th>
                                    <th>Precio adicional</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    <tr :key="index" v-for="(detalle,index) of DetalleProductos">
                                        <td>{{ detalle.talla }}</td>
                                        <td>{{ detalle.stock }}</td>
                                        <td>{{ detalle.precioadicional }} $</td>
                                        <td>
                                            <button @click="EliminarTalla(index)" class="btn btn-danger btn-sm">Eliminar</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </template>

            <template slot="acciones">
                <button @click="Guardar()" class="btn btn-primary">Guardar</button>
            </template>

        </modal-template>

    </div>

</template>

<script>

export default{

    data(){
        return{

            Productos : [],
            DetalleProductos : [],

            Talla : "",

            Producto : {
                Nombre : "",
                Descripsion : "",
                Precio : ""
            },

            DetalleUnitario : {
                Talla : "",
                Stock : "",
                PrecioAdicional : ""
            },

            TieneTallas : false,



        }
    },

    methods : {

        AgregarTalla(){

            let talla = {
                talla : this.DetalleUnitario.Talla,
                stock : this.DetalleUnitario.Stock,
                precioadicional : this.DetalleUnitario.PrecioAdicional
            };

            this.DetalleProductos.push(talla);

            this.DetalleUnitario.Talla = "";
            this.DetalleUnitario.Stock = "";
            this.DetalleUnitario.PrecioAdicional = "";

        },

        EliminarTalla(indice){

            this.DetalleProductos.splice(indice,1);

        },

        Guardar(){

            //condicion de si tiene tallas
            //si tiene guardara con todas las tallas que se creo de el producto
            if(this.TieneTallas){

                let Json = {
                    Nombre : this.Producto.Nombre,
                    Descripsion : this.Producto.Descripsion,
                    Precio : this.Producto.Precio,
                    NombreTalla : this.Talla,
                    Detalle : this.DetalleProductos
                };

                axios.post(
                    '../api/producto/guardardetalles',
                    {"Json" : JSON.stringify(Json)}
                ).then( (Respuesta) => {

                    this.Listar();

                    $("#modal_producto").modal('hide');
                    

                });

            } else {



            }


        },

        Listar(){

            axios.get(
                '../api/producto'
            ).then( (Respuesta) => {

                this.Productos = Respuesta.data;

            });

        },

        AbrirModal(){

            $("#modal_producto").modal();

        }

    },

    created(){

        this.Listar();

    }

}

</script>