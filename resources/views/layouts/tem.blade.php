// Update category
        $('#formUpdate').on('submit', function(event) {
            event.preventDefault();

            if ($('#buttonUpdate').val() == "Update") {
                $.ajax({
                    url: "{{route('providers.update')}}",
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
                url: "provaider/destroy/" + id,
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
                url: "/provaider/edit/" + ide,
                dataType: "json",
                success: function(html) {
                    $('#name').val(html.data.name);
                    $('#hidden_id').val(html.data.id);
                    $('#updateCategory').modal('show');
                }
            });

        });