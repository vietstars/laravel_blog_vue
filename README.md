// create category table model
# php artisan make:model Category -m

// create post table model
# php artisan make:model Post -m

// faker generater.php
# php artisan db:seed

// mix route:
Route::get('/{anypath}', 'DashboardController@index')->where('path','.*');

// vform https://www.npmjs.com/package/vform
npm i axios vform
<form role="form" @submit.prevent="addCategory()">
<input type="text" v-model="form.cat_name" name="cat_name">


//vue in blade template @{{ $route.name }}

// Vuex store: -> state{}, actions{}, mutations{} using actions to handle rest and parse mutation to state then getters to get state

// sweetalert2 https://sweetalert2.github.io/

// upload image from basecode: http://image.intervention.io/getting_started/installation
# composer require intervention/image 