<template>
        <div>
        
        <section class="content-header">
          
        </section>
        <section class="content" v-if="$gate.isAdmin()">
            <div class="box">
                    <div class="box-header with-border">
                          <h3 class="box-title">Users</h3>
                          <button class="btn btn-success pull-right" @click="newModal">Add new user <i class="fas fa-user-plus"></i> </button>
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
                          <th>Registered at</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in users" :key="user.id">
                          <td>{{ user.id }}</td>
                          <td>{{ user.name }}</td>
                          <td>{{ user.email }}</td>
                          <td>{{ user.type | upText }}</td>
                          <td>{{ user.created_at | myDate }}</td>
                          <td>
                            <a href="#" @click="editModal(user)"><i class="fas fa-edit">edit</i></a>
                            //
                            <a href="#" @click="deleteUser(user.id)"><i class="fas fa-trash">delete</i></a>
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
                    <h5 v-show="!editmode" class="modal-title" id="addUserModalLabel">Add new user</h5>
                    <h5 v-show="editmode" class="modal-title" id="addUserModalLabel">Edit user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form @submit.prevent="editmode ? updateUser() : createUser()">
                  <div class="modal-body">
                        
                            <div class="form-group">
                              <label>Name</label>
                              <input v-model="form.name" type="text" name="name" id="name" 
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                              <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                              <label>Email</label>
                              <input v-model="form.email" type="text" name="email" id="email" 
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                              <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                              <label>Bio</label>
                              <textarea v-model="form.bio" type="text" name="bio" id="bio" 
                                class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }">
                              </textarea>
                              <has-error :form="form" field="bio"></has-error>
                            </div>
                            <div class="form-group">
                              <label>User role</label>
                              <select v-model="form.type" name="type" id="type" 
                                class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                  <option value="">Select user role</option>
                                  <option value="admin">Admin</option>
                                  <option value="user">Standard user</option>
                                  <option value="author">Author</option>
                              </select>
                              <has-error :form="form" field="type"></has-error>
                            </div>

                            <div class="form-group">
                              <label>Password</label>
                              <input v-model="form.password" type="password" name="password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                              <has-error :form="form" field="password"></has-error>
                            </div>

                            
                        
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button  v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                     <button v-show="editmode" type="submit" class="btn btn-primary">Edit</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
        <!-- /modal -->
      </div>  
    
</template>

<script>
    export default {
        data () {
                return {
                  editmode: false,
                  users: {},  
                  // Create a new form instance
                  form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                  })
                }
              },
        methods: {
            updateUser(){
            this.$Progress.start();
            this.form.put('api/user/' + this.form.id).then( () => {
                
                $('#addUserModal').modal('hide')
                Fire.$emit('AfterUpdate')
                 swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: 'User updated',
                  showConfirmButton: false,
                  timer: 1500
                })

                  }) //if not
             .catch( () => {
                this.$Progress.fail()
                swal.fire({
                  //position: 'top-end',
                  type: 'error',
                  title: 'Error!',
                  showConfirmButton: false,
                  timer: 1500
                })
             })
             this.$Progress.finish(); 
         },
           editModal(user){
              this.editmode = true;
              this.form.fill(user);
              $('#addUserModal').modal('show');
           },
           newModal(){
              this.form.reset();
              $('#addUserModal').modal('show');
           },
           showUsers(){
              if (this.$gate.isAdmin()){
              this.$Progress.start();
              axios.get("api/user").then( ({ data }) => (this.users = data.data) );
              this.$Progress.finish();}
           },
           createUser(){
             this.$Progress.start();

             this.form.post('api/user')
             //if is successful
             .then( () => {
                Fire.$emit('AfterCreate')

                $('#addUserModal').modal('hide')

                 swal.fire({
                  position: 'top-end',
                  type: 'success',
                  title: 'User created',
                  showConfirmButton: false,
                  timer: 1500
                })

                 this.$Progress.finish();

             })
             //if not
             .catch( () => {
                swal.fire({
                  //position: 'top-end',
                  type: 'error',
                  title: 'Fill in all fields',
                  showConfirmButton: false,
                  timer: 1500
                })
             })

             
           },
           deleteUser(id){
                swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    //send ajax request for deleting
                    
                    if (result.value) {
                      this.form.delete('api/user/' + id).then( () => {
                       swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    )
                  })
                }
                Fire.$emit('AfterDelete')
                }).catch( () => {
                    swal("Failed!","There is something wrong","warning")
                })
           }
       

        },
        created() {
            this.showUsers();
            Fire.$on('AfterCreate',() => {
                 this.showUsers() 
            });
            Fire.$on('AfterDelete',() => {
                 this.showUsers() 
            });
            Fire.$on('AfterUpdate',() => {
                 this.showUsers() 
            });
           
        }
    }
</script>
