@extends('welcome')

@section('title', 'home')

@section('sidebar')
@parent

@endsection

@section('content')
<h2 class="text-center m-3">Welcome</h2>
<hr class="col-6">

<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-header bg bg-info">
                New ticket
            </div>
            <div class="card-body">
                <form method="POST" id="formInsert" class="text-center " enctype="multipart/form-data">
                    @csrf
                    <span id="form_result"></span>
                    <div class="well well-sm">
                        <table id="tabla" class="table text-center table table-striped table-bordered" style="width:100%">
                            <thead class="bg bg-gray">
                                <tr>
                                    <th>Name product</th>
                                    <th>Quantity</th>
                                    <th><input type="button" id="add" value="Add row" class="btn btn-primary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="product_id[]" id="product_id" class="form-control">
                                            <option>Select...</option>
                                            @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->nameProduct}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type='number' name='quantity[]' id="quantity" class="form-control">
                                    </td>
                                    <td><input type='button' class='del btn btn-danger' value='Delete row'></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="submit" id="buttonAdd" class="btn btn-primary btn-lg" value="Generate">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <canvas id="myChart" style="display: block; width: 45%; height: 40%;" class="chartjs-render-monitor"></canvas>
    <div class="clearfix">
        <hr><br>
    </div>
</div>

</div>

<script>
    /* Add column with */
    $(document).ready(function() {
        /**
         * Funcion para añadir una nueva fila en la tabla
         */
        $("#add").click(function() {
            var nuevaFila = "<tr> \
				<td><select name='product_id[]' id='product_idS' required class='form-control'><option>Selecciona ...</option>@foreach($products as $product)<option value='{{$product->cost}}'>{{$product->nameProduct}}</option>@endforeach</select></td> \
                <td><input type='number' name='quantity[]' required class='form-control'></td> \
				<td><input type='button' class='del btn btn-danger' value='Delete row' class='btn btn-danger'></td> \
			</tr>";
            $("#tabla tbody").append(nuevaFila);
        });

        // evento para eliminar la fila
        $("#tabla").on("click", ".del", function() {
            $(this).parents("tr").remove();
        });

        $('#formInsert').on('submit', function(event) {
            event.preventDefault();

            if ($('#buttonAdd').val() == "Generate") {
                $.ajax({
                    url: "{{route('home.store')}}",
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


    });
    /* Fin */
    

    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: 'SALES',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            animation: {
                duration: 0
            },
            hover: {
                animationDuration: 0
            },
            responsiveAnimationDuration: 0
        }
    });
</script>

@endsection