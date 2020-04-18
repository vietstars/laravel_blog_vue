<template>
    <div class="app-content content">
        <div class="content-wrapper">   
            <div class="content-wrapper-before" style="height: 120px!important;"></div>
            <div class="content-header row">
              <div class="content-header-left col-md-4 col-12 mb-2">
                <h3 class="content-header-title">Category</h3>
              </div>
              <div class="content-header-right col-md-8 col-12">
                <div class="breadcrumbs-top float-md-right">
                  <div class="breadcrumb-wrapper mr-1">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="dashboard.html">Dashboard</a>
                      </li>
                      <li class="breadcrumb-item active">
                        Category
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">Category list</h2>                                
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a class="btn btn-primary btn-sm white" data-toggle="modal" data-target="#newCatModal">
                                                <i class="ft-plus font-medium-3"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <table class="table table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Category Name</th>
                                            <th width="15%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Category Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr v-for="(category,i) in getallCategory" :key="category.id">
                                            <td>{{i}}</td>
                                            <td>
                                                {{ category.category_name | capitalize }}<span class="float-right">Created at: {{ category.created_at | dateformat }}</span><br/><small class="danger">Update at: {{ category.updated_at | dateTimeformat }}</small>
                                                </td>
                                            <td>
                                                <a href="" class="mr-3" data-toggle="modal" data-target="#detailCatModal" @click.prevent="detailCategory(category.id,category.category_name)"><i class="ft-edit-3"></i> Edit</a>
                                                <a href="" @click.prevent="removeCategory(category.id)"><i class="ft-trash-2"></i> Remove</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="newCatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form @submit.prevent="addCategory()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="categoryId">Category</label>
                                <input type="text" class="form-control" v-model="form.category_name" name="category_name" id="category_name" placeholder="Add new category name" :class="{ 'is-invalid': form.errors.has('category_name') }">
                                <has-error :form="form" field="category_name"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" @click="hideModal('newCatModal')">Add new</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="detailCatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form @submit.prevent="updateCategory()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Category detail</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" v-model="form.category_id" id="categoryId" name="category_id">
                                <label for="categoryId">Category name</label>
                                <input type="text" class="form-control" v-model="form.category_name" name="category_name" id="categoryName" placeholder="Enter category name" :class="{ 'is-invalid': form.errors.has('category_name') }">
                                <has-error :form="form" field="category_name"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" @click="hideModal('detailCatModal')">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "List",
        data(){
            return {
                form: new Form({
                    category_id:'',
                    category_name:''
                })
            }
        },
        mounted: function () {
            // app.$emit('page', this.$route.name);
            // this.$parent.page = this.$route.name
            this.$store.dispatch("allCategory")
        },
        computed: {
            getallCategory(){
                return this.$store.getters.getCategory
            }
        },
        methods: {
            addCategory(){
                swal.fire({
                    title: 'Warning !!!',
                    text: 'Do you want to create new category?',
                    icon: 'warning',
                    // position: 'top-end',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, send!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.value) {
                        this.form.post('/add-category')
                        .then((res)=>{
                            // this.$router.push('/dashboard');
                            swal.fire(
                                'Successful!',
                                'Your new category has been created.',
                                'success'
                            ).then((res)=>{
                                window.location.reload();
                            })
                        })
                        .catch(()=>{

                        })
                    } else if (result.dismiss === swal.DismissReason.cancel) {
                        swal.fire(
                            'Cancelled',
                            'Your category is safe :)',
                            'error'
                        )
                    }
                })     
            },
            hideModal(modalId) {
               const modal = document.getElementById(modalId);
                // change state like in hidden modal
                modal.classList.remove('show');
                modal.setAttribute('aria-hidden', 'true');
                modal.setAttribute('style', 'display: none');
                // get modal backdrop
                const modalBackdrops = document.getElementsByClassName('modal-backdrop');
                // remove opened modal backdrop
                document.body.classList.remove('modal-open');
                document.body.removeAttribute("style");
                document.querySelector('.header-navbar').removeAttribute("style");
                document.body.removeChild(modalBackdrops[0]);
            },
            removeCategory(id){
                swal.fire({
                    title: 'Warning !!!',
                    text: 'Do you want to remove new category?',
                    icon: 'warning',
                    // position: 'top-end',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.value) {
                        axios.get(`/category/${id}`)
                        .then((res)=>{
                            swal.fire(
                                'Successful!',
                                'Your new category has been deleted.',
                                'success'
                            ).then((res)=>{
                                window.location.reload();
                            })
                        })
                        .catch(()=>{

                        })
                    } else if (result.dismiss === swal.DismissReason.cancel) {
                        swal.fire(
                            'Cancelled',
                            'Your category is safe :)',
                            'error'
                        )
                    }
                })
            },
            detailCategory(id,category){
                this.form.fill({
                    category_id: id,
                    category_name: category
                })
                document.querySelector('#categoryId').value=id;
                document.querySelector('#categoryName').value=category;
            },
            updateCategory(){
                swal.fire({
                    title: 'Warning !!!',
                    text: 'Do you want to update this category?',
                    icon: 'warning',
                    // position: 'top-end',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, update!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.value) {
                        this.form.post('/update-category')
                        .then((res)=>{
                            // this.$router.push('/dashboard');
                            swal.fire(
                                'Successful!',
                                'Your new category has been updated.',
                                'success'
                            ).then((res)=>{
                                window.location.reload();
                            })
                        })
                        .catch(()=>{

                        })
                    } else if (result.dismiss === swal.DismissReason.cancel) {
                        swal.fire(
                            'Cancelled',
                            'Your category is safe :)',
                            'error'
                        )
                    }
                })                
            }
        }
    }
</script>

<style scoped>
    
</style>
