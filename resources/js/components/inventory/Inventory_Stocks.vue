<template>

<div class="card">

<!-- HEADER -->
<div class="card-header">
	Stock Information
    <button class="btn btn-primary btn-sm float-right" @click="inventory_stock_reset()" data-toggle="modal" data-target="#inventory_stock_modal">
        <i class="fas fa-plus-circle"></i> Add Stock
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
	<div class="col">Item Name: <b>{{ inventory_item_name }}</b> </div>
	<div class="col">Stock Qty: <b>{{ inventory_stock_balance }}</b> </div>
</div>
<hr>
<!-- END INFORMATION -->
	
<!-- TABLE -->
<p class="float-right"> 
	{{ pagination.from_entries }}-{{ pagination.to_entries }} of {{ pagination.total }} Total Entries 
</p>
<div class="form-group form-inline">
	<input class="form-control" type="text" placeholder="Keyword (Min. 2 Chars.)" v-model="keyword" @keydown.enter="inventory_stocks_fetch()">
	&nbsp
	<button class="btn btn-primary btn-sm" @click="inventory_stocks_fetch()">
		<i class="fas fa-search"></i> Search
	</button>
</div>
<div class="table-responsive">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="text-center">Date</th>
				<th class="text-center">Source/DR No.</th>
				<th class="text-center">In</th>
				<th class="text-center">Out</th>
				<th class="text-center">Purpose</th>
				<th class="text-center">Withdrawn By</th>
				<th class="text-center">Unit Location</th>
				<th class="text-center">Action</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="inventory_stock in inventory_stocks" v-bind:key="inventory_stock.inventory_stock_id">
				<td> {{ dateformat(inventory_stock.inventory_stock_date) }}</td>
				<td> {{ inventory_stock.inventory_stock_source }} </td>
				<td> {{ inventory_stock.inventory_stock_in }} </td>
				<td> {{ inventory_stock.inventory_stock_out }} </td>
				<td> {{ inventory_stock.inventory_stock_purpose }} </td>
				<td> {{ inventory_stock.inventory_stock_withdrawn_by }} </td>
				<td> {{ inventory_stock.inventory_stock_unit_location }} </td>
				<td>
					<center>
						<button class="btn btn-info btn-sm" @click="inventory_stock_update(inventory_stock)" data-toggle="modal" data-target="#inventory_stock_modal" style="width: 90px;">
							<i class="fas fa-edit"></i> Edit
						</button>
						<button class="btn btn-danger btn-sm" @click="inventory_stock_delete(inventory_stock.inventory_stock_id)" style="width: 90px;"> 
							<i class="fas fa-trash"></i> Delete
						</button>
					</center>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<ul class="pagination justify-content-center">
	<li v-bind:class="[{ disabled: !pagination.prev_page_url }]" class="page-item">
		<a class="page-link" href="#" @click="inventory_stocks_fetch(pagination.prev_page_url)"> 
			Previous <i class="fas fa-chevron-left"></i> 
		</a>
	</li>
	<li class="page-item disabled">
		<a class="page-link text-dark"> 
			Page {{ pagination.current_page }} of {{ pagination.last_page }}
		</a>
	</li>
	<li v-bind:class="[{ disabled: !pagination.next_page_url }]" class="page-item">
		<a class="page-link" href="#" @click="inventory_stocks_fetch(pagination.next_page_url)"> 
			<i class="fas fa-chevron-right"></i> Next 
		</a>
	</li>
</ul>
<!-- END TABLE -->
</div>

<!-- MODAL -->
<div class="modal fade" id="inventory_stock_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <p class="modal-title">Stock Information</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form @submit.prevent="inventory_stock_submit()">
            	<div class="modal-body">

            		<div class="row">
                		<div class="col">
                            
                            <div class="form-group">
                            	<label>Date</label>
                                <input class="form-control" type="date" v-model="inventory_stock.inventory_stock_date" required>
                            </div>
                            <div class="form-group">
                            	<input class="form-control" type="text" placeholder="Source/DR No." v-model="inventory_stock.inventory_stock_source" required>
                            </div>
                            <div class="form-group">
                            	<input class="form-control" type="text" placeholder="Purpose" v-model="inventory_stock.inventory_stock_purpose" required>
                            </div>

                        </div>
                        <div class="col">

                            <div class="form-group">
                            	<label>Available Qty: {{ inventory_stock_balance }}</label>
                                <input class="form-control" type="number" placeholder="Stock In" v-model="inventory_stock.inventory_stock_in" min="0">
                                <input class="form-control" type="number" placeholder="Stock Out" v-model="inventory_stock.inventory_stock_out" min="0" :max="inventory_stock_balance">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Withdrawn By" v-model="inventory_stock.inventory_stock_withdrawn_by" required>
                            </div>
                            <div class="form-group">
                            	<input class="form-control" type="text" placeholder="Unit Location" v-model="inventory_stock.inventory_stock_unit_location">
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
				inventory_item_name: '',
				inventory_stock_balance: '',
				inventory_stocks: [],
				inventory_stock: {
					inventory_id: window.location.pathname.split("/").pop(),
					inventory_stock_id: '',
					inventory_stock_date: '',
					inventory_stock_source: '',
					inventory_stock_in: '',
					inventory_stock_out: '',
					inventory_stock_purpose: '',
					inventory_stock_withdrawn_by: '',
					inventory_stock_unit_location: '',
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
			this.inventory_stocks_fetch();
			this.inventory_info_fetch();
			this.inventory_qty_fetch();
		},
		methods: {
			dateformat(value){
				return  (value == '0001-01-01') ? '':moment(String(value)).format('MM/DD/YYYY');
			},
			inventory_info_fetch(){
				axios.get('/api/inventory_item/' + this.inventory_stock.inventory_id)
				.then(res => {
					this.inventory_item_name = res.data.inventory_item;
				})
				.catch(err => console.log(err));
			},
			inventory_qty_fetch(){
				axios.get('/api/inventory_stock_balance/' + this.inventory_stock.inventory_id)
				.then(res => {
					this.inventory_stock_balance = res.data.stock_balance;
				})
				.catch(err => console.log(err));
			},
			inventory_stocks_fetch(page_url = '/api/inventory_stocks/' + this.inventory_stock.inventory_id){
				let config = {};
				let is_fetchable = false;
				if(this.keyword.length >= 2){
					config = {
						method: 'post',
						url: page_url,
						data: { 
							inventory_id: this.inventory_stock.inventory_id,
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
						this.inventory_stocks = res.data.data;
						this.inventory_stocks_pagination(res.data.meta, res.data.links);
						this.inventory_qty_fetch();
					})
					.catch(err => console.log(err));
				}
			},
			inventory_stocks_pagination(meta, links){
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
			inventory_stock_reset(){
				this.edit = false;
				this.inventory_stock.inventory_stock_id = '';
				this.inventory_stock.inventory_stock_date = '';
				this.inventory_stock.inventory_stock_source = '';
				this.inventory_stock.inventory_stock_in = '';
				this.inventory_stock.inventory_stock_out = '';
				this.inventory_stock.inventory_stock_purpose = '';
				this.inventory_stock.inventory_stock_withdrawn_by = '';
				this.inventory_stock.inventory_stock_unit_location = '';
			},
			inventory_stock_submit(){
				let method = '';
				let message = '';
				if(this.edit === true){
					method = 'put';
					message = 'Item Stock updated.';
					this.edit = false;
				}else{
					method = 'post';
					message = 'Item Stock added.';
				}
				axios({
					method: method,
					url: '/api/inventory_stock',
					data: this.inventory_stock
				})
				.then(res => {
					if(res.data.errors){
						this.notification_alert('Warning!', res.data.errors);
					}else{
						this.notification_alert('Success!', message);
						this.inventory_stocks_fetch();
						this.inventory_stock_reset();
					}
					$('#inventory_stock_modal').modal('hide');
				})
				.catch(err => console.log(err));
			},
			inventory_stock_update(inventory_stock){
				this.edit = true;
				this.inventory_stock.inventory_stock_id = inventory_stock.inventory_stock_id;
				this.inventory_stock.inventory_stock_date = inventory_stock.inventory_stock_date;
				this.inventory_stock.inventory_stock_source = inventory_stock.inventory_stock_source;
				this.inventory_stock.inventory_stock_in = inventory_stock.inventory_stock_in;
				this.inventory_stock.inventory_stock_out = inventory_stock.inventory_stock_out;
				this.inventory_stock.inventory_stock_purpose = inventory_stock.inventory_stock_purpose;
				this.inventory_stock.inventory_stock_withdrawn_by = inventory_stock.inventory_stock_withdrawn_by;
				this.inventory_stock.inventory_stock_unit_location = inventory_stock.inventory_stock_unit_location;
			},
			inventory_stock_delete(id){
				if(confirm('Are you sure you want to delete?')) {
					axios.delete('/api/inventory_stock/'+id)
					.then(res => {
						this.notification_alert('Success!', 'Item Stock removed.');
						this.inventory_stocks_fetch();
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