<template>

<div class="card">
	
<!-- HEADER -->
<div class="card-header">
	Repair Job Orders
    <button class="btn btn-primary btn-sm float-right" @click="repair_job_order_reset()" data-toggle="modal" data-target="#repair_job_order_modal">
        <i class="fas fa-plus-circle"></i> Add Job Order
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

<!-- INFORMATION -->
<div class="row">
	<div class="col">Equipment Name: <b>{{ equipment_name }}</b> </div>
	<div class="col">Model ID: <b>{{ equipment_model_no }}</b> </div>
</div>
<hr>
<!-- END INFORMATION -->
	
<!-- TABLE -->
<p class="float-right"> 
	{{ pagination.from_entries }}-{{ pagination.to_entries }} of {{ pagination.total }} Total Entries 
</p>
<div class="form-group form-inline">
	<input class="form-control" type="text" placeholder="Keyword (Min. 2 Chars.)" v-model="keyword" @keydown.enter="repair_job_orders_fetch()">
	&nbsp
	<button class="btn btn-primary btn-sm" @click="repair_job_orders_fetch()">
		<i class="fas fa-search"></i> Search
	</button>
</div>
<div class="table-responsive">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="text-center">Date Requested</th>
				<th class="text-center">Date Needed</th>
				<th class="text-center">Requestor's Name</th>
				<th class="text-center">Date of Breakdown</th>
				<th class="text-center">Maintenance Incharge</th>
				<th class="text-center">Details of Breakdown</th>
				<th class="text-center">Action Taken</th>
				<th class="text-center">Repair Results</th>
				<th class="text-center">Action</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="repair_job_order in repair_job_orders" v-bind:key="repair_job_order.repair_job_order_id">
				<td> {{ dateformat(repair_job_order.repair_job_order_date_requested) }}</td>
				<td> {{ dateformat(repair_job_order.repair_job_order_date_needed) }} </td>
				<td> {{ repair_job_order.repair_job_order_requestors_name }} </td>
				<td> {{ dateformat(repair_job_order.repair_job_order_date_breakdown) }} </td>
				<td> 
					Internal: {{ repair_job_order.repair_job_order_for_maintenance_incharge_internal }} <br>
					External: {{ repair_job_order.repair_job_order_for_maintenance_incharge_external }} 
				</td>
				<td> {{ repair_job_order.repair_job_order_breakdown_type }} </td>
				<td> {{ repair_job_order.repair_job_order_action_taken }} </td>
				<td> 
					{{ repair_job_order.repair_job_order_repair_results }} <br>
					Repair Started: {{ dateformat(repair_job_order.repair_job_order_repair_started) }} <br>
					Repair Ended: {{ dateformat(repair_job_order.repair_job_order_repair_ended) }}
				</td>
				<td>
					<center>
						<button class="btn btn-info btn-sm" @click="repair_job_order_update(repair_job_order)" data-toggle="modal" data-target="#repair_job_order_modal" style="width: 90px;">
							<i class="fas fa-edit"></i> Edit
						</button>

						<button class="btn btn-danger btn-sm" @click="repair_job_order_delete(repair_job_order.repair_job_order_id)" style="width: 90px;"> 
							<i class="fas fa-trash"></i> Delete
						</button>
						<a class="btn btn-primary btn-sm" style="width: 90px;"> 
							<i class="fas fa-tools"></i> Parts
						</a>
						<a class="btn btn-warning btn-sm" :href="'/repair_job_order_pdf/' + repair_job_order.repair_job_order_id" style="width: 90px;"> 
							<i class="fas fa-file-pdf"></i> Print
						</a>
					</center>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<ul class="pagination justify-content-center">
	<li v-bind:class="[{ disabled: !pagination.prev_page_url }]" class="page-item">
		<a class="page-link" href="#" @click="repair_job_orders_fetch(pagination.prev_page_url)"> 
			Previous <i class="fas fa-chevron-left"></i> 
		</a>
	</li>
	<li class="page-item disabled">
		<a class="page-link text-dark"> 
			Page {{ pagination.current_page }} of {{ pagination.last_page }}
		</a>
	</li>
	<li v-bind:class="[{ disabled: !pagination.next_page_url }]" class="page-item">
		<a class="page-link" href="#" @click="repair_job_orders_fetch(pagination.next_page_url)"> 
			<i class="fas fa-chevron-right"></i> Next 
		</a>
	</li>
</ul>
<!-- END TABLE -->
</div>

<!-- MODAL -->
<div class="modal fade" id="repair_job_order_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <p class="modal-title">Job Order Information</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form @submit.prevent="repair_job_order_submit()">
            	<div class="modal-body">

            		<div class="row">
                		<div class="col">
                            
                            <div class="form-group">
                            	<label>Date Requested</label>
                                <input class="form-control" type="date" v-model="repair_job_order.repair_job_order_date_requested" required>
                            </div>
                            <div class="form-group">
                            	<label>Date Needed</label>
                                <input class="form-control" type="date" v-model="repair_job_order.repair_job_order_date_needed">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Requestor's Name" v-model="repair_job_order.repair_job_order_requestors_name" required>
                            </div>
                            <div class="form-group">
                            	<label>Date of Breakdown</label>
                                <input class="form-control" type="date" v-model="repair_job_order.repair_job_order_date_breakdown">
                            </div>
                            <div class="form-group">
                            	<label>For Maintenance In-charge</label>
                                <input class="form-control" type="text" placeholder="Internal" v-model="repair_job_order.repair_job_order_for_maintenance_incharge_internal" >
                                <input class="form-control" type="text" placeholder="External (Outsourced)" v-model="repair_job_order.repair_job_order_for_maintenance_incharge_external" >
                            </div>

                        </div>
                        <div class="col">

                            <div class="form-group">
                            	<label>Diagnose Details</label>
                                <select class="form-control" v-model="repair_job_order.repair_job_order_breakdown_type">
                                	<option value="">Details of Breakdown</option>
                                	<option value="Mechanical">Mechanical</option>
                                	<option value="Electrical">Electrical</option>
                                	<option value="Calibration">Calibration</option>
                                	<option value="Hydraulics">Hydraulics</option>
                                	<option value="Tinsmith">Tinsmith</option>
                                	<option value="Welding">Welding</option>
                                	<option value="Painting">Painting</option>
                                	<option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="form-group">
                            	<label>Repair Details</label>
                                <select class="form-control" v-model="repair_job_order.repair_job_order_action_taken">
                                	<option value="">Action Taken</option>
                                	<option value="Replace">Replace</option>
                                	<option value="Resurface">Resurface</option>
                                	<option value="Repair">Repair</option>
                                	<option value="Restore">Restore</option>
                                	<option value="Rebuild">Rebuild</option>
                                	<option value="Recondition">Recondition</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Repair Results (OK or Not OK)" v-model="repair_job_order.repair_job_order_repair_results">
                            </div>
                            <div class="form-group">
                            	<label>Repair Started</label>
                            	<input class="form-control" type="date" v-model="repair_job_order.repair_job_order_repair_started">
                            </div>
                            <div class="form-group">
                            	<label>Repair Ended</label>
                            	<input class="form-control" type="date" v-model="repair_job_order.repair_job_order_repair_ended">
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
</div>	

</template>

<script>
	import moment from 'moment'
	export default{
		data() {
			return {
				equipment_name: '',
				equipment_model_no: '',
				repair_job_orders: [],
				repair_job_order: {
					equipment_id: window.location.pathname.split("/").pop(),
					repair_job_order_id: '',
					repair_job_order_date_requested: '',
					repair_job_order_date_needed: '',
					repair_job_order_requestors_name: '',
					repair_job_order_date_breakdown: '',
					repair_job_order_for_maintenance_incharge_internal: '',
					repair_job_order_for_maintenance_incharge_external: '',
					repair_job_order_breakdown_type: '',
					repair_job_order_action_taken: '',
					repair_job_order_repair_results: '',
					repair_job_order_repair_started: '',
					repair_job_order_repair_ended: '',
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
			this.repair_job_orders_fetch();
			this.equipment_info_fetch();
		},
		methods: {
			dateformat(value){
				return  (value == '0001-01-01') ? '':moment(String(value)).format('MM/DD/YYYY');
			},
			equipment_info_fetch(){
				axios.get('/api/equipment/' + this.repair_job_order.equipment_id)
				.then(res => {
					this.equipment_name = res.data.equipment_name;
					this.equipment_model_no = res.data.equipment_model_no;
				})
				.catch(err => console.log(err));
			},
			repair_job_orders_fetch(page_url = '/api/repair_job_orders/' + this.repair_job_order.equipment_id){
				let config = {};
				let is_fetchable = false;
				if(this.keyword.length >= 2){
					config = {
						method: 'post',
						url: page_url,
						data: { 
							equipment_id: this.repair_job_order.equipment_id,
							keyword: this.keyword 
						}
					};
					is_fetchable = true;
				}else if(this.keyword == ''){
					config = {
						method: 'get',
						url: page_url
					};
					is_fetchable = true;
				}
				if(is_fetchable){
					axios(config)
					.then(res => {
						this.repair_job_orders = res.data.data;
						this.repair_job_orders_pagination(res.data.meta, res.data.links);
					})
					.catch(err => console.log(err));
				}
			},
			repair_job_orders_pagination(meta, links){
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
			repair_job_order_reset(){
				this.edit = false;
				this.repair_job_order.repair_job_order_id = '';
				this.repair_job_order.repair_job_order_date_requested = '';
				this.repair_job_order.repair_job_order_date_needed = '';
				this.repair_job_order.repair_job_order_requestors_name = '';
				this.repair_job_order.repair_job_order_date_breakdown = '';
				this.repair_job_order.repair_job_order_for_maintenance_incharge_internal = '';
				this.repair_job_order.repair_job_order_for_maintenance_incharge_external = '';
				this.repair_job_order.repair_job_order_breakdown_type = '';
				this.repair_job_order.repair_job_order_action_taken = '';
				this.repair_job_order.repair_job_order_repair_results = '';
				this.repair_job_order.repair_job_order_repair_started = '';
				this.repair_job_order.repair_job_order_repair_ended = '';
			},
			repair_job_order_submit(){
				let method = '';
				let message = '';
				if(this.edit === true){
					method = 'put';
					message = 'Job Order updated.';
					this.edit = false;
				}else{
					method = 'post';
					message = 'Job Order added.';
				}
				axios({
					method: method,
					url: '/api/repair_job_order',
					data: this.repair_job_order
				})
				.then(res => {
					if(res.data.errors){
						this.notification_alert('Warning!', res.data.errors);
					}else{
						this.notification_alert('Success!', message);
						this.repair_job_orders_fetch();
						this.repair_job_order_reset();
					}
					$('#repair_job_order_modal').modal('hide');
				})
				.catch(err => console.log(err));
			},
			repair_job_order_update(repair_job_order){
				this.edit = true;
				this.repair_job_order.repair_job_order_id = repair_job_order.repair_job_order_id;
				this.repair_job_order.repair_job_order_date_requested = repair_job_order.repair_job_order_date_requested;
				this.repair_job_order.repair_job_order_date_needed = repair_job_order.repair_job_order_date_needed;
				this.repair_job_order.repair_job_order_requestors_name = repair_job_order.repair_job_order_requestors_name;
				this.repair_job_order.repair_job_order_date_breakdown = repair_job_order.repair_job_order_date_breakdown;
				this.repair_job_order.repair_job_order_for_maintenance_incharge_internal = repair_job_order.repair_job_order_for_maintenance_incharge_internal;
				this.repair_job_order.repair_job_order_for_maintenance_incharge_external = repair_job_order.repair_job_order_for_maintenance_incharge_external;
				this.repair_job_order.repair_job_order_breakdown_type = repair_job_order.repair_job_order_breakdown_type;
				this.repair_job_order.repair_job_order_action_taken = repair_job_order.repair_job_order_action_taken;
				this.repair_job_order.repair_job_order_repair_results = repair_job_order.repair_job_order_repair_results;
				this.repair_job_order.repair_job_order_repair_started = repair_job_order.repair_job_order_repair_started;
				this.repair_job_order.repair_job_order_repair_ended = repair_job_order.repair_job_order_repair_ended;
			},
			repair_job_order_delete(id){
				if(confirm('Are you sure you want to delete?')) {
					axios.delete('/api/repair_job_order/'+id)
					.then(res => {
						this.notification_alert('Success!', 'Job Order removed.');
						this.repair_job_orders_fetch();
					})
					.catch(err => console.log(err));
				}
			},
			notification_alert(notification_type, notification_message){
				this.notification_type = notification_type;
				this.notification_message = notification_message;
				this.notification_show = true;
				setTimeout(() => this.notification_show = false, 5000);
			}
		}
	}
</script>