<template>
	
<div class="card">

<!-- HEADER -->
<div class="card-header">
	Item Information
    <button class="btn btn-primary btn-sm float-right" @click="inventory_reset()" data-toggle="modal" data-target="#inventory_modal">
        <i class="fas fa-plus-circle"></i> Add Item
    </button>
</div>
<!-- END HEADER -->

<div class="card-body">
<!-- NOTIFICATION -->
<div class="col" v-show="notification_show">
	<div class="alert" v-bind:class="[ notification_type == 'Warning!' ? 'alert-danger':'alert-success' ]">
		<strong>{{ notification_type }}</strong> {{ notification_message }}
	</div>
</div>
<!-- END NOTIFICATION -->

<!-- TABLE -->
<p class="float-right"> 
	{{ pagination.from_entries }}-{{ pagination.to_entries }} of {{ pagination.total }} Total Entries 
</p>
<div class="form-group form-inline">
	<input class="form-control" type="text" placeholder="Keyword (Min. 2 Chars.)" v-model="keyword" @keydown.enter="inventory_fetch()">
	&nbsp
	<button class="btn btn-primary btn-sm" @click="inventory_fetch()">
		<i class="fas fa-search"></i> Search
	</button>
</div>
<div class="table-responsive">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="text-center">Item Name</th>
				<th class="text-center">Description</th>
				<th class="text-center">Action</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="inventory in inventory_list" v-bind:key="inventory.inventory_id">
				<td> {{ inventory.inventory_item }}</td>
				<td> {{ inventory.inventory_description }} </td>
				<td>
					<center>
						<button class="btn btn-secondary btn-sm" @click="inventory_image_select(inventory.inventory_id)" data-toggle="modal" data-target="#inventory_image_modal" style="width: 90px;">
							<i class="fas fa-image"></i> Images
						</button>
						<button class="btn btn-info btn-sm" @click="inventory_update(inventory)" data-toggle="modal" data-target="#inventory_modal" style="width: 90px;">
							<i class="fas fa-edit"></i> Edit
						</button>
						<button class="btn btn-danger btn-sm" @click="inventory_delete(inventory.inventory_id)" style="width: 90px;"> 
							<i class="fas fa-trash"></i> Delete
						</button>
						<a class="btn btn-primary btn-sm" :href="'/inventory_stocks/' + inventory.inventory_id" style="width: 90px;"> 
							<i class="fas fa-sticky-note"></i> Stocks
						</a>
						<a class="btn btn-warning btn-sm" :href="'/inventory_pdf/' + inventory.inventory_id"> 
							<i class="fas fa-file-pdf"></i> Print Card
						</a>
					</center>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<ul class="pagination justify-content-center">
	<li v-bind:class="[{ disabled: !pagination.prev_page_url }]" class="page-item">
		<a class="page-link" href="#" @click="inventory_fetch(pagination.prev_page_url)"> 
			Previous <i class="fas fa-chevron-left"></i> 
		</a>
	</li>
	<li class="page-item disabled">
		<a class="page-link text-dark"> 
			Page {{ pagination.current_page }} of {{ pagination.last_page }}
		</a>
	</li>
	<li v-bind:class="[{ disabled: !pagination.next_page_url }]" class="page-item">
		<a class="page-link" href="#" @click="inventory_fetch(pagination.next_page_url)"> 
			<i class="fas fa-chevron-right"></i> Next 
		</a>
	</li>
</ul>
<!-- END TABLE -->
</div>

<!-- MODAL -->
<div class="modal fade" id="inventory_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <p class="modal-title">Item Information</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form @submit.prevent="inventory_submit()">
            	<div class="modal-body">

            		<div class="row">
                		<div class="col">
                            
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Item" v-model="inventory.inventory_item" required>
                            </div>

                        </div>
                        <div class="col">
                            
                            <div class="form-group">
                            	<textarea class="form-control" placeholder="Description" v-model="inventory.inventory_description">
                            	</textarea>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                	<button class="btn btn-primary btn-sm">
                		<i class="fas fa-pen"></i> Submit
                	</button>
                </div>
            </form>
		</div>
		
	</div>
</div>
<!-- END MODAL -->

<!-- IMAGE MODAL -->
<div class="modal fade" id="inventory_image_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <p class="modal-title">Item Images</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        	<div class="modal-body">

        		<div id="demo" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ul class="carousel-indicators">
						<li data-target="#demo" :data-slide-to="index" v-bind:class="index == 0 ? 'active':''" v-for="(inventory_image_path, index) in inventory_images"></li>
					</ul>
					<!-- The slideshow -->
					<div class="carousel-inner">
						<div class="carousel-item" v-bind:class="index == 0 ? 'active':''" v-for="(inventory_image_path, index) in inventory_images">
							<img v-bind:src="'/uploads/' + inventory_image_path.inventory_image_file_path" width="450px" height="350px">
							<div class="carousel-caption">
								<button class="btn btn-danger btn-sm float-right" title="Delete Image!" @click="inventory_image_delete(inventory_image_path.inventory_image_id)">
									<i class="fas fa-trash"></i>
								</button>
							</div>
						</div>
					</div>
					<!-- Left and right controls -->
					<a class="carousel-control-prev" href="#demo" data-slide="prev">
						<span class="carousel-control-prev-icon"></span>
					</a>
					<a class="carousel-control-next" href="#demo" data-slide="next">
						<span class="carousel-control-next-icon"></span>
					</a>
				</div>
				<br>
        		<div class="row">

        			<div class="col">
        				<form id="inventory_image_form">
	        				<div class="form-group">
	        					<label>Browse Image to Upload</label>
	                            <input class="form-control" type="file" @change="inventory_image_browsed">
	                        </div>
                        </form>
        			</div>

        		</div>

            </div>
            <div class="modal-footer">
            	<button class="btn btn-danger btn-sm" data-dismiss="modal">
                	<i class="fas fa-window-close"></i>	Close
                </button>
            	<button class="btn btn-primary btn-sm" @click="inventory_image_submit()">
            		<i class="fas fa-pen"></i> Upload
            	</button>
            </div>
		</div>
		
	</div>
</div>
<!-- END IMAGE MODAL -->
</div>

</template>

<script>
	export default{
		data() {
			return {
				inventory_list: [],
				inventory: {
					inventory_id: '',
					inventory_item: '',
					inventory_description: '',
				},
				inventory_image: {
					inventory_id: '',
					inventory_image_file_path: null
				},
				inventory_images: [],
				inventory_image_path: {
					inventory_image_id: '',
					inventory_image_file_path: '',
				},
				pagination: {},
				keyword: '',
				edit: false,
				notification_message: '',
				notification_type: '',
				notification_show: false
			}
		},
		created() {
			this.inventory_fetch();
		},
		methods: {
			inventory_fetch(page_url = '/api/inventory'){
				let config = {};
				let is_fetchable = false;
				if(this.keyword.length >= 2){
					config = {
						method: 'post',
						url: page_url,
						data: { keyword: this.keyword }
					};
					is_fetchable = true;
				}else if(this.keyword == ''){
					config = {
						method: 'get',
						url: page_url,
					};
					is_fetchable = true;
				}
				if(is_fetchable){
					axios(config)
					.then(res => {
						this.inventory_list = res.data.data;
						this.inventory_pagination(res.data.meta, res.data.links);
					})
					.catch(err => console.log(err));
				}
			},
			inventory_pagination(meta, links){
				let pagination = {
					current_page: meta.current_page,
					last_page: meta.last_page,
					from_entries: meta.from,
					to_entries: meta.to,
					total: meta.total,
					next_page_url: links.next,
					prev_page_url: links.prev
				};
				this.pagination = pagination;
			},
			inventory_reset(){
				this.edit = false;
				this.inventory.inventory_id = '';
				this.inventory.inventory_item = '';
				this.inventory.inventory_description = '';
			},
			inventory_submit(){
				let method = '';
				let message = '';
				if(this.edit === true){
					method = 'put';
					message = 'Item updated.';
					this.edit = false;
				}else{
					method = 'post';
					message = 'Item added.';
				}
				axios({
					method: method,
					url: '/api/inventory_item',
					data: this.inventory
				})
				.then(res => {
					if(res.data.errors){
						this.notification_alert('Warning!', res.data.errors);
					}else{
						this.notification_alert('Success!', message);
						this.inventory_fetch();
						this.inventory_reset();
					}
					$('#inventory_modal').modal('hide');
				})
				.catch(err => console.log(err));
			},
			inventory_update(inventory){
				this.edit = true;
				this.inventory.inventory_id = inventory.inventory_id;
				this.inventory.inventory_item = inventory.inventory_item;
				this.inventory.inventory_description = inventory.inventory_description;
			},
			inventory_delete(id){
				if(confirm('Are you sure you want to delete?')) {
					axios.delete('/api/inventory_item/'+id)
					.then(res => {
						this.notification_alert('Success!', 'Item removed.');
						this.inventory_fetch();
					})
					.catch(err => console.log(err));
				}
			},
			notification_alert(notification_type, notification_message){
				this.notification_type = notification_type;
				this.notification_message = notification_message;
				this.notification_show = true;
				setTimeout(() => this.notification_show = false, 5000);
			},
			inventory_image_select(id){
				this.inventory_image.inventory_id = id;
				axios.get('/api/inventory_image/'+id)
				.then(res => {
					this.inventory_images = res.data;
				});
			},
			inventory_image_browsed(event){
				let file = event.target.files[0];
				if(file.size <= 2097152){
					if(file.type == 'image/jpeg' || file.type == 'image/png'){
						let reader = new FileReader();
						reader.readAsDataURL(file);
						reader.onload = (e) => { this.inventory_image.inventory_image_file_path = e.target.result; }
					}else
						alert("Image must be jpeg/jpg or png.");
				}else
					alert("Image must not exceed 2mb.");
			},
			inventory_image_submit(){
				if(this.inventory_image.inventory_image_file_path != null){
					axios.post('/api/inventory_image', this.inventory_image, {
						onUploadProgress: uploadEvent => {
							console.log('Upload Progress: ' + Math.round(uploadEvent.loaded / uploadEvent.total) * 100);
						}
					})
					.then(res => {
						this.notification_alert('Success!', 'Image uploaded successfully.');
						this.inventory_image.inventory_image_file_path = null;
						this.inventory_image.inventory_id = '';
						$('#inventory_image_form')[0].reset();
						$('#inventory_image_modal').modal('hide');
					});
				}else{
					this.notification_alert('Warning!', 'File must be png or jpeg/jpg and must not exceed 2mb. Failed to upload.');
					$('#inventory_image_modal').modal('hide');
				}
			},
			inventory_image_delete(id){
				if(confirm('Are you sure you want to delete image?')){
					axios.delete('/api/inventory_image/'+id)
					.then(res => {
						this.notification_alert('Success!', 'Item image removed.');
						$('#inventory_image_modal').modal('hide');
					})
					.catch(err => console.log(err));
				}
			}
		}
	}
</script>