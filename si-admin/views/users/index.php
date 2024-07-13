<?php
// session_start();
// if (!isset($_SESSION['user'])) {
    // return header('Location: http://localhost/web-porto/si-admin/views/Login/' );

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Users - Web Porto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  </head>
  <body>
    <div class="container">
        <div id="message">
        </div>
        <h1 class="mt-4 mb-4 text-center text-danger">USERS
        CRUD</h1>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col col-sm-9">USERS</div>
                    <div class="col col-sm-3">
                        <button type="button" id="add_data" class="btn btn-success btn-sm float-end">Add</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="sample_data">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal" tabindex="-1" id="action_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="sample_form">
                        <div class="modal-header">
                            <h5 class="modal-title" id="dynamic_modal_title"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="full_name" id="full_name" class="form-control" />
                                <span id="full_name_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" />
                                <span id="email_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" />
                                    <span id="password_error" class="text-danger"></span>
                                </div>
                            <div class="mb-3">
                                <label class="form-label">Job</label>
                                <input type="text" name="job" id="job" class="form-control" />
                                <span id="job_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Expected Position</label>
                                <input type="text" name="expected_position" id="expected_position" class="form-control" />
                                <span id="expected_position_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Photo</label>
                                <input type="text" name="photo" id="photo" class="form-control" />
                                <span id="photo_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" id="id" />
                            <input type="hidden" name="action" id="action" value="Add" />
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="action_button">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    
    <script>
    $(document).ready(function() {
        showAll();

        $('#add_data').click(function(){
            $('#dynamic_modal_title').text('Add Biodata User');
            $('#sample_form')[0].reset();
            $('#action').val('Add');
            $('#action_button').text('Add');
            $('.text-danger').text('');
            $('#action_modal').modal('show');
        });
        
        $('#sample_form').on('submit', function(event){
            event.preventDefault();
            if($('#action').val() == "Add"){
                var formData = {
                'full_name' : $('#full_name').val(),
                'email' : $('#email').val(),
                'password' : $('#password').val(),
                'job' : $('#job').val(),
                'expected_position' : $('#expected_position').val(),
                'photo' : $('#photo').val()
                }

                $.ajax({
                    url:"http://localhost/web-porto/si-admin/api/users/create.php",
                    method:"POST",
                    data: JSON.stringify(formData),
                    success:function(data){
                        $('#action_button').attr('disabled', false);
                        $('#message').html('<div class="alert alert-success">'+data.message+'</div>');
                        $('#action_modal').modal('hide');
                        $('#sample_data').DataTable().destroy();
                        showAll();
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }else if($('#action').val() == "Update"){
                var formData = {
                    'id' : $('#id').val(),
                    'full_name' : $('#full_name').val(),
                    'email' : $('#email').val(),
                    'password' : $('#password').val(),
                    'job' : $('#job').val(),
                    'expected_position' : $('#expected_position').val(),
                    'photo' : $('#photo').val()
                }

                $.ajax({
                    url:"http://localhost/web-porto/si-admin/api/users/update.php",
                    method:"PUT",
                    data: JSON.stringify(formData),
                    success:function(data){
                        $('#action_button').attr('disabled', false);
                        $('#message').html('<div class="alert alert-success">'+data.message+'</div>');
                        $('#action_modal').modal('hide');
                        $('#sample_data').DataTable().destroy();
                        showAll();
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }
            });
    });

    function showAll() {
        $.ajax({
            type: "GET",
            contentType: "application/json",
            url:"http://localhost/web-porto//si-admin/api/users/read.php",
            success: function(response) {
            // console.log(response);
                var json = response.body;
                var dataSet=[];
                for (var i = 0; i < json.length; i++) {
                    var sub_array = {
                        'full_name' : json[i].full_name,
                        'email' : json[i].email,
                        'job' : json[i].job,
                        'expected_position' : json[i].expected_position,
                        'action' : '<button onclick="showOne('+json[i].id+')" class="btn btn-sm btn-warning">Edit</button>'+
                        '<button onclick="deleteOne('+json[i].id+')" class="btn btn-sm btn-danger">Delete</button>'
                    };
                    dataSet.push(sub_array);
                }
                $('#sample_data').DataTable({
                    data: dataSet,
                    columns : [
                        { data : "full_name" },
                        { data : "email" },
                        { data : "job" },
                        { data : "expected_position" },
                        { data : "action" }
                    ]
                });
            },
            error: function(err) {
                console.log(err);
            }
        });
    }

    function showOne(id) {
        $('#dynamic_modal_title').text('Edit Biodata User');
        $('#sample_form')[0].reset();
        $('#action').val('Update');
        $('#action_button').text('Update');
        $('.text-danger').text('');
        $('#action_modal').modal('show');

        $.ajax({
            type: "GET",
            contentType: "application/json",
            url:
            "http://localhost/web-porto/si-admin/api/users/read.php?id="+id,
            success: function(response) {
                $('#id').val(response.id);
                $('#full_name').val(response.full_name);
                $('#email').val(response.email);
                $('#password').val(response.password);
                $('#job').val(response.job);
                $('#expected_position').val(response.expected_position);
                $('#photo').val(response.photo);
            },
            error: function(err) {
                console.log(err);
            }
        });
    }

    function deleteOne(id) {
    if (confirm('Yakin untuk hapus data ?')) {
        $.ajax({
            url: "http://localhost/web-porto/si-admin/api/users/delete.php",
            method: "DELETE",
            data: JSON.stringify({"id": id}),
            contentType: "application/json; charset=utf-8",
            success: function(data) {
                $('#message').html('<div class="alert alert-success">' + data.message + '</div>');
                $('#sample_data').DataTable().destroy();
                showAll();
            },
            error: function(err) {
                console.log(err);
                $('#message').html('<div class="alert alert-danger">Error deleting data</div>');
            }
        });
    }
}
    </script>
</body>
</html>