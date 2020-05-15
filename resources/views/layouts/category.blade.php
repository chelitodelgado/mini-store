@extends('welcome')

@section('title', 'Category')

@section('sidebar')
@parent

@endsection

@section('content')

<hr class="col-6">
<div class="row">

    <div class="col-5">
        <div class="card">
            <div class="card-header bg bg-info">
                Add Category
            </div>
            <div class="card-body">
                <form method="POST" id="formInsert" class="text-center " enctype="multipart/form-data">
                @csrf
                    <span id="form_result"></span>
                    <p class="lead text-justify">Name category</p>
                    <input type="text" class="form-control" name="name" placeholder="Name category" autofocus required><br>
                    <input type="submit" id="buttonAdd" class="btn btn-primary" value="Save">
                </form>
            </div>
        </div>
    </div>

    <div class="col-6">
        <table id="tableCategory" class="table text-center table table-striped" style="width:100%">
            <thead>
                <tr class="bg bg-warning">
                    <th># ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg bg-danger">
                <h4 class="modal-title">Confirm!</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure to delete this category?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-warning">Yess</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="updateCategory" class="modal fede" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg bg-warning">
                <h4 class="modal-title">Update!</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <form method="POST" id="formUpdate" class="text-center " enctype="multipart/form-data">
                @csrf
                    <span id="form_resultM"></span>
                    <p class="lead text-justify">Update category</p>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name category" autofocus required><br>
                    <input type="submit" id="buttonUpdate" class="btn btn-primary" value="Update">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function() {

        // fill table categories
        $('#tableCategory').DataTable({
            "processing": true,
            "serverSide": true,
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            "ajax": "{{ route('category_view.index') }}",
            "columns": [
                { "data": "id" },
                { "data": "nameCategory" },
                { "data": "action" }
            ]
        });
        // End

        // Add category
        $('#formInsert').on('submit', function(event) {
            event.preventDefault();

            if ($('#buttonAdd').val() == "Save") {
                $.ajax({
                    url: "{{route('category.store')}}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        var hmlt = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger alert-dismissible">';
                            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>Valide los campos</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            html = '<button class="btn btn-success">Success <i class="fas fa-check-circle"></i></button>';
                            $('#formInsert')[0].reset();
                            $('#tableCategory').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html);
                        $('#form_result').show();
                        setTimeout(function() {
                            $('#form_result').hide();
                        }, 2000);
                    }
                });
            }

        });

        // Update category
        $('#formUpdate').on('submit', function(event) {
            event.preventDefault();

            if ($('#buttonUpdate').val() == "Update") {
                $.ajax({
                    url: "{{route('category.update')}}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        var hmlt = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger alert-dismissible">';
                            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>Comprueba el campo nombre categoria</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            html = '<button class="btn btn-success">Success <i class="fas fa-check-circle"></i></button>';
                            $('#tableCategory').DataTable().ajax.reload();
                        }
                        $('#form_resultM').html(html);
                        $('#form_resultM').show();
                        setTimeout(function() {
                            $('#form_resultM').hide();
                        }, 2000);
                    }
                });
            }

        })

        // Delete category
        let id;
        $(document).on('click', '.delete', function() {
            id = $(this).attr('id');
            $('#confirmModal').modal('show');
        });

        $('#ok_button').click(function() {
            $.ajax({
                url: "category/destroy/" + id,
                success: function(data) {
                    $('#tableCategory').DataTable().ajax.reload();
                    $('#ok_button').text('Yess');
                    $('#confirmModal').modal('hide');
                }
            });
        });

        // Click edit
        $(document).on('click', '.edit', function() {
            let ide = $(this).attr('id');
            $('#form_result').html('');
            $.ajax({
                url: "/category/edit/" + ide,
                dataType: "json",
                success: function(html) {
                    $('#name').val(html.data.nameCategory);
                    $('#hidden_id').val(html.data.id);
                    $('#updateCategory').modal('show');
                }
            });

        });

    });

</script> 
   
@endsection