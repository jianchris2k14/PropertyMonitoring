<template>

<div class="card">

<!-- HEADER -->
<div class="card-header">
	Equipments Information
    <button class="btn btn-primary btn-sm float-right" @click="equipment_reset()" data-toggle="modal" data-target="#equipment_modal">
        <i class="fas fa-plus-circle"></i> Add Equipment
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
	<input class="form-control" type="text" placeholder="Keyword (Min. 2 Chars.)" v-model="keyword" @keydown.enter="equipments_fetch()">
	&nbsp
	<button class="btn btn-primary btn-sm" @click="equipments_fetch()">
		<i class="fas fa-search"></i> Search
	</button>
</div>
<div class="table-responsive">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="text-center">Equipment Name</th>
				<th class="text-center">Model No.</th>
				<th class="text-center">Serial No.</th>
				<th class="text-center">Chassis No.</th>
				<th class="text-center">Plate No.</th>
				<th class="text-center">Engine No.</th>
				<th class="text-center">Manufacturer</th>
				<th class="text-center">Date Purchased</th>
				<th class="text-center">Action</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="equipment in equipments" v-bind:key="equipment.equipment_id">
				<td> {{ equipment.equipment_name }}</td>
				<td> {{ equipment.equipment_model_no }} </td>
				<td> {{ equipment.equipment_serial_no }} </td>
				<td> {{ equipment.equipment_chassis_no }} </td>
				<td> {{ equipment.equipment_plate_no }} </td>
				<td> {{ equipment.equipment_engine_no }} </td>
				<td> {{ equipment.equipment_manufacturer }} </td>
				<td> {{ dateformat(equipment.equipment_date_purchased) }} </td>
				<td>
					<center>
						<button class="btn btn-secondary btn-sm" @click="equipment_image_select(equipment.equipment_id)" data-toggle="modal" data-target="#equipment_image_modal" style="width: 90px;">
							<i class="fas fa-image"></i> Images
						</button>
						<button class="btn btn-info btn-sm" @click="equipment_update(equipment)" data-toggle="modal" data-target="#equipment_modal" style="width: 90px;">
							<i class="fas fa-edit"></i> Edit
						</button>
						<button class="btn btn-danger btn-sm" @click="equipment_delete(equipment.equipment_id)" style="width: 90px;"> 
							<i class="fas fa-trash"></i> Delete
						</button>
						<a class="btn btn-primary btn-sm" :href="'/repair_job_orders/' + equipment.equipment_id" style="width: 90px;"> 
							<i class="fas fa-tools"></i> Repair
						</a>
						<a class="btn btn-warning btn-sm" :href="'/equipment_pdf/' + equipment.equipment_id"> 
							<i class="fas fa-file-pdf"></i> Print Record
						</a>
					</center>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<ul class="pagination justify-content-center">
	<li v-bind:class="[{ disabled: !pagination.prev_page_url }]" class="page-item">
		<a class="page-link" href="#" @click="equipments_fetch(pagination.prev_page_url)"> 
			Previous <i class="fas fa-chevron-left"></i> 
		</a>
	</li>
	<li class="page-item disabled">
		<a class="page-link text-dark"> 
			Page {{ pagination.current_page }} of {{ pagination.last_page }}
		</a>
	</li>
	<li v-bind:class="[{ disabled: !pagination.next_page_url }]" class="page-item">
		<a class="page-link" href="#" @click="equipments_fetch(pagination.next_page_url)"> 
			<i class="fas fa-chevron-right"></i> Next 
		</a>
	</li>
</ul>
<!-- END TABLE -->
</div>

<!-- MODAL -->
<div class="modal fade" id="equipment_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <p class="modal-title">Equipment Information</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form @submit.prevent="equipment_submit()">
            	<div class="modal-body">

            		<div class="row">
                		<div class="col">
                            
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Equipment Name" v-model="equipment.equipment_name" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Model No." v-model="equipment.equipment_model_no">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Serial No." v-model="equipment.equipment_serial_no">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Chassis No." v-model="equipment.equipment_chassis_no">
                            </div>

                        </div>
                        <div class="col">
                            
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Plate No." v-model="equipment.equipment_plate_no" >
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Engine No." v-model="equipment.equipment_engine_no" >
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Manufacturer" v-model="equipment.equipment_manufacturer">
                            </div>
                            <div class="form-group">
                            	<input class="form-control" type="date" placeholder="Date Purchased" v-model="equipment.equipment_date_purchased" required>
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
<div class="modal fade" id="equipment_image_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <p class="modal-title">Equipment Images</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        	<div class="modal-body">

        		<div id="demo" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ul class="carousel-indicators">
						<li data-target="#demo" :data-slide-to="index" v-bind:class="index == 0 ? 'active':''" v-for="(equipment_image_path, index) in equipment_images"></li>
					</ul>
					<!-- The slideshow -->
					<div class="carousel-inner">
						<div class="carousel-item" v-bind:class="index == 0 ? 'active':''" v-for="(equipment_image_path, index) in equipment_images">
							<img v-bind:src="'/uploads/' + equipment_image_path.equipment_image_file_path" width="450px" height="350px">
							<div class="carousel-caption">
								<button class="btn btn-danger btn-sm float-right" title="Delete Image!" @click="equipment_image_delete(equipment_image_path.equipment_image_id)">
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
        				<form id="equipment_image_form">
	        				<div class="form-group">
	        					<label>Browse Image to Upload</label>
	                            <input class="form-control" type="file" @change="equipment_image_browsed">
	                        </div>
                        </form>
        			</div>

        		</div>

            </div>
            <div class="modal-footer">
            	<button class="btn btn-danger btn-sm" data-dismiss="modal">
                	<i class="fas fa-window-close"></i>	Close
                </button>
            	<button class="btn btn-primary btn-sm" @click="equipment_image_submit()">
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
	import moment from 'moment'
	export default{
		data() {
			return {
				equipments: [],
				equipment: {
					equipment_id: '',
					equipment_name: '',
					equipment_model_no: '',
					equipment_serial_no: '',
					equipment_chassis_no: '',
					equipment_plate_no: '',
					equipment_engine_no: '',
					equipment_manufacturer: '',
					equipment_date_purchased: '',
				},
				equipment_image: {
					equipment_id: '',
					equipment_image_file_path: null
				},
				equipment_images: [],
				equipment_image_path: {
					equipment_image_id: '',
					equipment_image_file_path: '',
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
			this.equipments_fetch();
		},
		methods: {
			dateformat(value){
				 return moment(String(value)).format('MM/DD/YYYY');
			},
			equipments_fetch(page_url = '/api/equipments'){
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
						this.equipments = res.data.data;
						this.equipments_pagination(res.data.meta, res.data.links);
					})
					.catch(err => console.log(err));
				}
			},
			equipments_pagination(meta, links){
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
			equipment_reset(){
				this.edit = false;
				this.equipment.equipment_id = '';
				this.equipment.equipment_name = '';
				this.equipment.equipment_model_no = '';
				this.equipment.equipment_serial_no = '';
				this.equipment.equipment_chassis_no = '';
				this.equipment.equipment_plate_no = '';
				this.equipment.equipment_engine_no = '';
				this.equipment.equipment_manufacturer = '';
				this.equipment.equipment_date_purchased = '';
			},
			equipment_submit(){
				let method = '';
				let message = '';
				if(this.edit === true){
					method = 'put';
					message = 'Equipment updated.';
					this.edit = false;
				}else{
					method = 'post';
					message = 'Equipment added.';
				}
				axios({
					method: method,
					url: '/api/equipment',
					data: this.equipment
				})
				.then(res => {
					if(res.data.errors){
						this.notification_alert('Warning!', res.data.errors);
					}else{
						this.notification_alert('Success!', message);
						this.equipments_fetch();
						this.equipment_reset();
					}
					$('#equipment_modal').modal('hide');
				})
				.catch(err => console.log(err));
			},
			equipment_update(equipment){
				this.edit = true;
				this.equipment.equipment_id = equipment.equipment_id;
				this.equipment.equipment_name = equipment.equipment_name;
				this.equipment.equipment_model_no = equipment.equipment_model_no;
				this.equipment.equipment_serial_no = equipment.equipment_serial_no;
				this.equipment.equipment_chassis_no = equipment.equipment_chassis_no;
				this.equipment.equipment_plate_no = equipment.equipment_plate_no;
				this.equipment.equipment_engine_no = equipment.equipment_engine_no;
				this.equipment.equipment_manufacturer = equipment.equipment_manufacturer;
				this.equipment.equipment_date_purchased = equipment.equipment_date_purchased;
			},
			equipment_delete(id){
				if(confirm('Are you sure you want to delete?')) {
					axios.delete('/api/equipment/'+id)
					.then(res => {
						this.notification_alert('Success!', 'Equipment removed.');
						this.equipments_fetch();
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
			equipment_image_select(id){
				this.equipment_image.equipment_id = id;
				axios.get('/api/equipment_image/'+id)
				.then(res => {
					this.equipment_images = res.data;
				});
			},
			equipment_image_browsed(event){
				let file = event.target.files[0];
				if(file.size <= 2097152){
					if(file.type == 'image/jpeg' || file.type == 'image/png'){
						let reader = new FileReader();
						reader.readAsDataURL(file);
						reader.onload = (e) => { this.equipment_image.equipment_image_file_path = e.target.result; }
					}else
						alert("Image must be jpeg/jpg or png.");
				}else
					alert("Image must not exceed 2mb.");
			},
			equipment_image_submit(){
				if(this.equipment_image.equipment_image_file_path != null){
					axios.post('/api/equipment_image', this.equipment_image, {
						onUploadProgress: uploadEvent => {
							console.log('Upload Progress: ' + Math.round(uploadEvent.loaded / uploadEvent.total) * 100);
						}
					})
					.then(res => {
						this.notification_alert('Success!', 'Image uploaded successfully.');
						this.equipment_image.equipment_image_file_path = null;
						this.equipment_image.equipment_id = '';
						$('#equipment_image_form')[0].reset();
						$('#equipment_image_modal').modal('hide');
					});
				}else{
					this.notification_alert('Warning!', 'File must be png or jpeg/jpg and must not exceed 2mb. Failed to upload.');
					$('#equipment_image_modal').modal('hide');
				}
			},
			equipment_image_delete(id){
				if(confirm('Are you sure you want to delete image?')){
					axios.delete('/api/equipment_image/'+id)
					.then(res => {
						this.notification_alert('Success!', 'Equipment image removed.');
						$('#equipment_image_modal').modal('hide');
					})
					.catch(err => console.log(err));
				}
			}
		}
	}
</script>