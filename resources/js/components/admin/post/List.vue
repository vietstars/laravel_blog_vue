<template>
    <div class="app-content content">
        <div class="content-wrapper">   
            <div class="content-wrapper-before" style="height: 120px!important;"></div>
            <div class="content-header row">
              <div class="content-header-left col-md-4 col-12 mb-2">
                <h3 class="content-header-title">Post</h3>
              </div>
              <div class="content-header-right col-md-8 col-12">
                <div class="breadcrumbs-top float-md-right">
                  <div class="breadcrumb-wrapper mr-1">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="dashboard.html">Dashboard</a>
                      </li>
                      <li class="breadcrumb-item active">
                        Post
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
                                <h2 class="card-title">Post list</h2>                                
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a class="btn btn-primary btn-sm white" data-toggle="modal" data-target="#newPostModal" @click="initForm()">
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
                                            <th>Post</th>
                                            <th width="15%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Post</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr v-for="(post,i) in getallPost" :key="post.id">
                                            <td>{{i}}</td>
                                            <td>
                                                <img :src="post.photo" width="50px" height="50px" class="float-left mr-2"/>
                                                <span class="float-right">Update at: {{ post.updated_at | dateTimeformat }}
                                               </span> {{ post.title | capitalize }} [{{ post.category.category_name | capitalize }}]
                                                <small><br/>{{ post.description}}</small>
                                                <br/><small class="danger">Created at: {{ post.created_at | dateformat }} | Created by: {{ post.user.name |capitalize }}</small></td>
                                            <td>
                                                <a href="" class="mr-3" data-toggle="modal" data-target="#detailPostModal" @click.prevent="detailPost(post)"><i class="ft-edit-3"></i> Edit</a>
                                                <a href="" @click.prevent="removePost(post.id)"><i class="ft-trash-2"></i> Remove</a>
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
        <div class="modal fade" id="newPostModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form @submit.prevent="addPost('newPostModal')" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New post</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="categoryId">Title</label>
                                <input type="text" class="form-control" v-model="form.post_title" name="post_title" id="post_title" placeholder="Add new title" :class="{ 'is-invalid': form.errors.has('post_title') }">
                                <has-error :form="form" field="post_title"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="categoryId">Description</label>
                                <textarea type="text" class="form-control" v-model="form.post_description" name="post_description" id="post_description" placeholder="Add new description" :class="{ 'is-invalid': form.errors.has('post_description') }"></textarea>
                                <has-error :form="form" field="post_description"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="categoryId">Category</label>
                                <select class="form-control" v-model="form.category_id" name="category_id" id="category_id":class="{ 'is-invalid': form.errors.has('category_id') }">
                                    <option hidden>select one</option>
                                    <option :value="category.id" v-for="category in getallCategory">{{category.category_name}}</option>
                                </select>
                                <has-error :form="form" field="category_id"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="photoId">Photo</label>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" @change="changePhoto($event)" class="custom-file-input" name="post_photo" id="post_photo" :class="{ 'is-invalid': form.errors.has('post_photo') }">
                                        <label class="custom-file-label px-1" style="--text:'Pick';" for="post_photo">{{form.photo_name?form.photo_name:'Choise file'}}</label>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary px-1" @click="photoUrl()" type="button" id="imageFromUrl">Url</button>
                                    </div>
                                </div>
                                <img v-if="form.post_photo || form.photo_name.includes('http')" :src="form.photo_name.includes('http')?form.photo_name:form.post_photo" alt="upload image" width="100%" class="img-thumbnail">   
                                <has-error :form="form" field="post.photo"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add new</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="detailPostModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form @submit.prevent="updatePost('detailPostModal')">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Post detail</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" v-model="form.post_id" id="postId" name="post_id">
                                <label for="categoryId">Title</label>
                                <input type="text" class="form-control" v-model="form.post_title" name="post_title" id="postTitle" placeholder="Enter title" :class="{ 'is-invalid': form.errors.has('post_title') }">
                                <has-error :form="form" field="post_title"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="categoryId">Description</label>
                                <textarea type="text" class="form-control" v-model="form.post_description" name="post_description" id="postDescription" placeholder="Enter description" :class="{ 'is-invalid': form.errors.has('post_description') }"></textarea>
                                <has-error :form="form" field="post_description"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="categoryId">Category</label>
                                <select class="form-control" v-model="form.category_id" name="category_id" id="categoryId":class="{ 'is-invalid': form.errors.has('category_id') }">
                                    <option hidden>select one</option>
                                    <option :value="category.id" v-for="category in getallCategory">{{category.category_name}}</option>
                                </select>
                                <has-error :form="form" field="category_id"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="photoId">Photo</label>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" @change="changePhoto($event)" class="custom-file-input" name="post_photo" id="postPhoto" :class="{ 'is-invalid': form.errors.has('post_photo') }">
                                        <label class="custom-file-label px-1" style="--text:'Pick';" for="post_photo">{{form.photo_name?form.photo_name:'Choise file'}}</label>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary px-1" @click="photoUrl()" type="button" id="imageFromUrl">Url</button>
                                    </div>
                                </div>
                                <img v-if="form.post_photo || form.photo_name || form.photo_name.includes('http')" :src="form.photo_name.includes('http')?form.photo_name:(form.post_photo?form.post_photo:form.photo_name)" alt="upload image" width="100%" class="img-thumbnail">   
                                <has-error :form="form" field="post.photo"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
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
                    post_id:'',
                    post_title:'',
                    post_description:'',
                    category_id:'',
                    post_photo:'',
                    photo_name: ''
                }),
            }
        },
        mounted(){
            this.$store.dispatch("allCategory");
            this.$store.dispatch("gelAllPost");
        },
        computed: {
            getallCategory(){
                return this.$store.getters.getCategory
            },
            getallPost(){
                this.$store.getters.getAllPost.map(i=>{i.photo.includes('http')?i.photo:i.photo=`/public/img/post/post_${i.id}/${i.photo}`;return i;})
                return this.$store.getters.getAllPost
            }
        },
        methods: {
            initForm(){
                this.form.fill({
                    post_id:'',
                    post_title:'',
                    post_description:'',
                    category_id:'',
                    post_photo:'',
                    photo_name: ''
                })
            },
            changePhoto(event){
                let file  = event.target.files[0];
                if(file.size > 1048576)
                {
                    swal.fire(
                        'Oops...!',
                        'Your image is too large, max allow 1MB',
                        'error'
                    )
                }else{
                    this.form.photo_name = file.name.replace(/\-/g, '_').replace(/\s/g, '');
                    let reader = new FileReader();
                    reader.onload = e=>{this.form.post_photo = e.target.result;}
                    reader.readAsDataURL(file);
                }
            },
            photoUrl(){
                let url = prompt('Enter your image url!');
                this.form.photo_name = url;
                // swal.fire({
                //     title: 'Enter your image Url!',
                //     input: 'text',
                //     inputAttributes: {
                //         autocapitalize: 'off'
                //     },
                //     inputPlaceholder: 'Enter here',
                //     showCancelButton: true,
                //     confirmButtonText: 'Look up',
                //     // showLoaderOnConfirm: true,
                //     // preConfirm: (login) => {
                //     //     return fetch(`//api.github.com/users/${login}`)
                //     //       .then(response => {
                //     //         if (!response.ok) {
                //     //           throw new Error(response.statusText)
                //     //         }
                //     //         return response.json()
                //     //       })
                //     //       .catch(error => {
                //     //         Swal.showValidationMessage(
                //     //           `Request failed: ${error}`
                //     //         )
                //     //     })
                //     // },
                //     allowOutsideClick: () => !swal.isLoading()
                // }).then((result) => {
                //     if (result.value) {
                //         swal.fire({
                //             title: 'Your image from url',
                //             imageUrl: result.value
                //         })
                //         this.form.photo_name = result.value;
                //     }
                // })
            },
            addPost(modalId){
                swal.fire({
                    title: 'Warning !!!',
                    text: 'Do you want to create new post?',
                    icon: 'warning',
                    // position: 'top-end',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, send!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.value) {
                        this.form.post('/add-post')
                        .then((res)=>{
                            swal.fire(
                                'Successful!',
                                'Your new post has been created.',
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
                            'Your post is safe :)',
                            'error'
                        ).then((res)=>{
                            this.hideModal(modalId);
                            document.body.removeAttribute("style");
                        })
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
            removePost(id){
                swal.fire({
                    title: 'Warning !!!',
                    text: 'Do you want to remove this post?',
                    icon: 'warning',
                    // position: 'top-end',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.value) {
                        axios.get(`/post/${id}`)
                        .then((res)=>{
                            swal.fire(
                                'Successful!',
                                'Your post has been deleted.',
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
                            'Your post is safe :)',
                            'error'
                        )
                    }
                })
            },
            detailPost(post){
                this.form.fill({
                    post_id:post.id,
                    post_title:post.title,
                    post_description:post.description,
                    category_id:post.category_id,
                    photo_name: post.photo
                })
            },
            updatePost(modalId){
                swal.fire({
                    title: 'Warning !!!',
                    text: 'Do you want to update this post?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, update!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.value) {
                        this.form.post('/update-post')
                        .then((res)=>{
                            swal.fire(
                                'Successful!',
                                'Your post has been updated.',
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
                            'Your post is safe :)',
                            'error'
                        ).then((res)=>{
                            this.hideModal(modalId);
                            document.body.removeAttribute("style");
                        })
                    }
                })                
            }
        }
    }
</script>

<style scoped>

</style>
