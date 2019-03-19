<template>
        <div>
        
        <section class="content-header">
          
        </section>
        <section class="content">
            <div class="box">
                    <div class="box-header with-border">
                          <h3 class="box-title">Users</h3>
                          <button class="btn btn-success pull-right" data-toggle="modal" data-target="#addUserModal">Add new user <i class="fas fa-user-plus"></i> </button>
                    </div>

                    <div class="box-body">
                        <div class="w3-padding w3-white notranslate">
                        <table class="table table-condensed">
                        <thead>
                        <tr>
                          <th>Id</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Type</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                          <td>1</td>
                          <td>Doe</td>
                          <td>john@example.com</td>
                          <td>Admin</td>
                          <td>
                            <a href="#"><i class="fas fa-edit">edit</i></a>
                            //
                            <a href="#"><i class="fas fa-trash">delete</i></a>
                          </td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                    </div>
              </div>
              <!-- /.box -->
        </section>
        <!-- modal -->
          <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add new user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    ...
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Create</button>
                  </div>
                </div>
              </div>
            </div>
        <!-- /modal -->
      </div>  
    
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
