<?php
//session_start();
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
        <div id="message"></div>
        <h1 class="mt-4 mb-4 text-center text-danger">USERS CRUD</h1>
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col col-sm-9">SKILLS</div>
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
                    <th>User Id</th>
                    <th>Skill Name</th>
                    <th>Rating</th>
                    <th>Description</th>
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
                    <label class="form-label">User Id</label>
                    <input type="text" name="user_id" id="user_id" class="form-control" />
                    <span id="user_id_error" class="text-danger"></span>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Skill Name</label>
                    <input type="text" name="skill_name" id="skill_name" class="form-control" />
                    <span id="skill_name_error" class="text-danger"></span>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <input type="number" name="rating" id="rating" class="form-control" />
                    <span id="rating_error" class="text-danger"></span>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Description</label>
                    <input type="text" name="description" id="description" class="form-control" />
                    <span id="description_error" class="text-danger"></span>
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
      $(document).ready(function () {
        showAll();

        $("#add_data").click(function () {
          $("#dynamic_modal_title").text("Add Skill");
          $("#sample_form")[0].reset();
          $("#action").val("Add");
          $("#action_button").text("Add");
          $(".text-danger").text("");
          $("#action_modal").modal("show");
        });

        $("#sample_form").on("submit", function (event) {
          event.preventDefault();
          if ($("#action").val() == "Add") {
            var formData = {
              user_id: $("#user_id").val(),
              skill_name: $("#skill_name").val(),
              rating: $("#rating").val(),
              description: $("#description").val(),
            };

            $.ajax({
              url: "http://localhost/web-porto/si-admin/api/skills/create.php",
              method: "POST",
              contentType: "application/json",
              data: JSON.stringify(formData),
              success: function (data) {
                $("#action_button").attr("disabled", false);
                $("#message").html('<div class="alert alert-success">' + data.message + "</div>");
                $("#action_modal").modal("hide");
                $("#sample_data").DataTable().destroy();
                showAll();
              },
              error: function (err) {
                console.log(err);
                $("#message").html('<div class="alert alert-danger">Error adding data</div>');
              },
            });
          } else if ($("#action").val() == "Update") {
            var formData = {
              id: $("#id").val(),
              user_id: $("#user_id").val(),
              skill_name: $("#skill_name").val(),
              rating: $("#rating").val(),
              description: $("#description").val(),
            };

            $.ajax({
              url: "http://localhost/web-porto/si-admin/api/skills/update.php",
              method: "PUT",
              contentType: "application/json",
              data: JSON.stringify(formData),
              success: function (data) {
                $("#action_button").attr("disabled", false);
                $("#message").html('<div class="alert alert-success">' + data.message + "</div>");
                $("#action_modal").modal("hide");
                $("#sample_data").DataTable().destroy();
                showAll();
              },
              error: function (err) {
                console.log(err);
                $("#message").html('<div class="alert alert-danger">Error updating data</div>');
              },
            });
          }
        });
      });

      function showAll() {
        $.ajax({
          type: "GET",
          contentType: "application/json",
          url: "http://localhost/web-porto/si-admin/api/skills/read.php",
          success: function (response) {
            var json = response.body;
            var dataSet = [];
            for (var i = 0; i < json.length; i++) {
              var sub_array = {
                user_id: json[i].user_id,
                skill_name: json[i].skill_name,
                rating: json[i].rating,
                description: json[i].description,
                action: '<button onclick="showOne(' + json[i].id + ')" class="btn btn-sm btn-warning">Edit</button>' + '<button onclick="deleteOne(' + json[i].id + ')" class="btn btn-sm btn-danger mx-2">Delete</button>',
              };
              dataSet.push(sub_array);
            }
            $("#sample_data").DataTable({
              data: dataSet,
              columns: [
                { data: "user_id" },
                { data: "skill_name" },
                { data: "rating" },
                { data: "description" },
                { data: "action" },
              ],
            });
          },
          error: function (err) {
            console.log(err);
          },
        });
      }

      function showOne(id) {
        $("#dynamic_modal_title").text("Edit Skill");
        $("#sample_form")[0].reset();
        $("#action").val("Update");
        $("#action_button").text("Update");
        $(".text-danger").text("");
        $("#action_modal").modal("show");

        $.ajax({
          type: "GET",
          contentType: "application/json",
          url: "http://localhost/web-porto/si-admin/api/skills/read.php?id=" + id,
          success: function (response) {
            $("#id").val(response.id);
            $("#user_id").val(response.user_id);
            $("#skill_name").val(response.skill_name);
            $("#rating").val(response.rating);
            $("#description").val(response.description);
          },
          error: function (err) {
            console.log(err);
          },
        });
      }

      function deleteOne(id) {
            var konfirmasiUser = confirm("Yakin untuk hapus data ?");
            if (konfirmasiUser) {
                $.ajax({
                    url: "http://localhost/web-porto/si-admin/api/skills/delete.php",
                    method: "DELETE",
                    data: JSON.stringify({
                        id: id,
                    }),
                    success: function(data) {
                        $("#action_button").attr("disabled", false);
                        $("#message").html('<div class="alert alert-success">' + data + "</div>");
                        $("#action_modal").modal("hide");
                        $("#sample_data").DataTable().destroy();
                        showAll();
                    },
                    error: function(err) {
                        console.log(err);
                        $("#message").html('<div class="alert alert-danger">' + err.responseJSON + '</div>');
                    },
                });
            }
        }
    </script>
</body>
</html>
