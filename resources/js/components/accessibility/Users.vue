<template>

<div class="card">

<!-- HEADER -->
<div class="card-header">
	Users Management
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

<!-- NAV TABS -->
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a class="nav-link active" data-toggle="tab" href="#users">
			<i class="fas fa-user-friends"></i> Users
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#user_roles">
			<i class="fas fa-user-tag"></i> User Roles
		</a>
	</li>
</ul>
<!-- TAB PANES -->
<div class="tab-content">
	<div class="tab-pane container active" id="users">
		<br>
		<button class="btn btn-primary btn-sm float-right" @click="user_reset()" data-toggle="modal" data-target="#user_modal">
	        <i class="fas fa-plus-circle"></i> Add User
	    </button>
	    <br>
	    <hr>
	    <!-- USERS TABLE -->
		<p class="float-right"> 
			{{ user_pagination.from_entries }}-{{ user_pagination.to_entries }} of {{ user_pagination.total }} Total Entries 
		</p>
		<div class="form-group form-inline">
			<input class="form-control" type="text" placeholder="Keyword (Min. 2 Chars.)" v-model="keyword" @keydown.enter="users_fetch()">
			&nbsp
			<button class="btn btn-primary btn-sm" @click="users_fetch()">
				<i class="fas fa-search"></i> Search
			</button>
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th class="text-center">Fullname</th>
						<th class="text-center">Username</th>
						<th class="text-center">User Role</th>
						<th class="text-center">Date Registered</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="user in users" v-bind:key="user.user_id">
						<td> {{ user.lastname }}, {{ user.firstname }} {{ user.middlename }} </td>
						<td> {{ user.username }} </td>
						<td> {{ user.user_role }} </td>
						<td> {{ dateformat(user.date_reg) }} </td>
						<td>
							<center>
								<button class="btn btn-info btn-sm" @click="user_update(user)" data-toggle="modal" data-target="#user_modal" style="width: 75px;">
									<i class="fas fa-edit"></i> Edit
								</button>
								<button class="btn btn-danger btn-sm" @click="user_delete(user.user_id)" style="width: 75px;"> 
									<i class="fas fa-trash"></i> Delete
								</button>
							</center>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<ul class="pagination justify-content-center">
			<li v-bind:class="[{ disabled: !user_pagination.prev_page_url }]" class="page-item">
				<a class="page-link" href="#" @click="users_fetch(user_pagination.prev_page_url)"> 
					Previous <i class="fas fa-chevron-left"></i> 
				</a>
			</li>
			<li class="page-item disabled">
				<a class="page-link text-dark"> 
					Page {{ user_pagination.current_page }} of {{ user_pagination.last_page }}
				</a>
			</li>
			<li v-bind:class="[{ disabled: !user_pagination.next_page_url }]" class="page-item">
				<a class="page-link" href="#" @click="users_fetch(user_pagination.next_page_url)"> 
					<i class="fas fa-chevron-right"></i> Next 
				</a>
			</li>
		</ul>
		<!-- END USERS TABLE -->
	</div>
	<div class="tab-pane container fade" id="user_roles">
		<br>
		<button class="btn btn-primary btn-sm float-right" @click="user_role_reset()" data-toggle="modal" data-target="#user_role_modal">
	        <i class="fas fa-plus-circle"></i> Add User Role
	    </button>
	    <br>
	    <hr>
	    <!-- USER ROLE TABLE -->
		<p class="float-right"> 
			{{ user_role_pagination.from_entries }}-{{ user_role_pagination.to_entries }} of {{ user_role_pagination.total }} Total Entries 
		</p>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th class="text-center">User Role</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="user_role in user_roles" v-bind:key="user_role.user_role_id">
						<td> {{ user_role.user_role }} </td>
						<td>
							<center>
								<button class="btn btn-info btn-sm" @click="user_role_update(user_role)" data-toggle="modal" data-target="#user_role_modal" style="width: 75px;">
									<i class="fas fa-edit"></i> Edit
								</button>
								<button class="btn btn-danger btn-sm" @click="user_role_delete(user_role.user_role_id)" style="width: 75px;"> 
									<i class="fas fa-trash"></i> Delete
								</button>
							</center>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<ul class="pagination justify-content-center">
			<li v-bind:class="[{ disabled: !user_role_pagination.prev_page_url }]" class="page-item">
				<a class="page-link" href="#" @click="user_roles_fetch(user_role_pagination.prev_page_url)"> 
					Previous <i class="fas fa-chevron-left"></i> 
				</a>
			</li>
			<li class="page-item disabled">
				<a class="page-link text-dark"> 
					Page {{ user_role_pagination.current_page }} of {{ user_role_pagination.last_page }}
				</a>
			</li>
			<li v-bind:class="[{ disabled: !user_role_pagination.next_page_url }]" class="page-item">
				<a class="page-link" href="#" @click="user_roles_fetch(user_role_pagination.next_page_url)"> 
					<i class="fas fa-chevron-right"></i> Next 
				</a>
			</li>
		</ul>
		<!-- END USER ROLE TABLE -->
	</div>

</div>
	<!-- END NAV TABS -->
</div>

<!-- MODAL -->
<div class="modal fade" id="user_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <p class="modal-title">User</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form @submit.prevent="user_submit()">
            	<div class="modal-body">
            	
            		<div class="row">
                		<div class="col">
                            
                            <div class="form-group">
                            	<label>Person</label>
                                <select class="form-control" v-model="user.person_id" required>
                                	<option value="">Select Person</option>
                                	<option v-for="person_sel in persons_selection" :value="person_sel.person_id">
                                		{{ person_sel.lastname }}, {{ person_sel.firstname }} {{ person_sel.middlename }}
                                	</option>
                                </select>
                            </div>
                            <div class="form-group">
                            	<label>User Role</label>
                                <select class="form-control" v-model="user.user_role_id" required>
                                	<option value="">Select User Role</option>
                                	<option v-for="user_role_sel in user_roles_selection" :value="user_role_sel.user_role_id">
                                		{{ user_role_sel.user_role }}
                                	</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="col">

                        	<div class="form-group">
                                <input class="form-control" type="text" placeholder="Username" v-model="user.username" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" placeholder="Password" v-model="user.password" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" placeholder="Confirm Password" v-model="user.confirm_password" required>
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

<!-- MODAL -->
<div class="modal fade" id="user_role_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <p class="modal-title">User Role</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form @submit.prevent="user_role_submit()">
            	<div class="modal-body">
            	
            		<div class="row">
                		<div class="col">
                            
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="User Role" v-model="user_role.user_role" required>
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
	export default {
		data() {
			return {
				user_roles: [],
				user_role: {
					user_role_id: '',
					user_role: '',
				},
				user_role_pagination: {},
				user_role_edit: false,
				users: [],
				user: {
					user_id: '',
					username: '',
					firstname: '',
					middlename: '',
					lastname: '',
					password: '',
					confirm_password: '',
					user_role: '',
					user_role_id: '',
					person_id: '',
				},
				user_pagination: {},
				keyword: '',
				user_edit: false,
				notification_message: '',
				notification_type: '',
				notification_show: false,
				persons_selection: [],
				person_sel: {
					person_id: '',
					firstname: '',
					middlename: '',
					lastname: '',
				},
				user_roles_selection: [],
				user_role_sel: {
					user_role_id: '',
					user_role: '',
				}
			}
		},
		created() {
			this.user_roles_fetch();
			this.users_fetch();
			this.persons_selection_fetch();
			this.user_roles_selection_fetch();
		},
		methods: {
			dateformat(value){
				return moment(String(value)).format('MM/DD/YYYY hh:mm a');
			},
			persons_selection_fetch(){
				fetch('/api/persons_selection')
				.then(res => res.json())
				.then(res => {
					this.persons_selection = res;
				})
				.catch(err => console.log(err));
			},
			user_roles_selection_fetch(){
				fetch('/api/user_roles_selection')
				.then(res => res.json())
				.then(res => {
					this.user_roles_selection = res;
				})
				.catch(err => console.log(err));
			},
			user_roles_fetch(page_url = '/api/user_roles'){
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.user_roles = res.data;
					this.user_roles_pagination(res.meta, res.links);
				})
				.catch(err => console.log(err));
			},
			user_roles_pagination(meta, links){
				let user_role_pagination = {
					current_page: meta.current_page,
					last_page: meta.last_page,
					from_entries: meta.from,
					to_entries: meta.to,
					total: meta.total,
					next_page_url: links.next,
					prev_page_url: links.prev
				};
				this.user_role_pagination = user_role_pagination;
			},
			user_role_reset(){
				this.user_role_edit = false;
				this.user_role.user_role_id = '';
				this.user_role.user_role = '';
			},
			user_role_submit(){
				let method = '';
				let message = '';
				if(this.user_role_edit === true){
					method = 'put';
					message = 'User Role updated.';
					this.user_role_edit = false;
				}else{
					method = 'post';
					message = 'User Role added.';
				}
				fetch('/api/user_role', {
					method: method,
					body: JSON.stringify(this.user_role),
					headers: { 'content-type': 'application/json' }
				})
				.then(res => res.json())
				.then(res => {
					if(res.errors){
						this.notification_alert('Warning!', res.errors);
					}else{
						this.notification_alert('Success!', message);
						this.user_roles_fetch();
						this.user_role_reset();
						this.user_roles_selection_fetch();
					}
					$('#user_role_modal').modal('hide');
				})
				.catch(err => console.log(err));
			},
			user_role_update(user_role){
				this.user_role_edit = true;
				this.user_role.user_role_id = user_role.user_role_id;
				this.user_role.user_role = user_role.user_role;
			},
			user_role_delete(id){
				if(confirm('Are you sure you want to delete?')) {
					fetch('/api/user_role/'+id, {
						method: 'delete'
					})
					.then(res => res.json())
					.then(res => {
						this.notification_alert('Success!', 'User Role removed.');
						this.user_roles_fetch();
					})
					.catch(err => console.log(err));
				}
			},
			users_fetch(page_url = '/api/users'){
				let option = {};
				let is_fetchable = false;
				if(this.keyword.length >= 2){
					option = {
						method: 'post',
						body: JSON.stringify({ keyword: this.keyword }),
						headers: { 'content-type': 'application/json' }
					};
					is_fetchable = true;
				}else if(this.keyword == ''){
					option = {};
					is_fetchable = true;
				}
				if(is_fetchable){
					fetch(page_url, option)
					.then(res => res.json())
					.then(res => {
						this.users = res.data;
						this.users_pagination(res.meta, res.links);
					})
					.catch(err => console.log(err));
				}
			},
			users_pagination(meta, links){
				let user_pagination = {
					current_page: meta.current_page,
					last_page: meta.last_page,
					from_entries: meta.from,
					to_entries: meta.to,
					total: meta.total,
					next_page_url: links.next,
					prev_page_url: links.prev
				};
				this.user_pagination = user_pagination;
			},
			user_reset(){
				this.user_edit = false;
				this.user.user_id = '';
				this.user.username = '';
				this.user.password = '';
				this.user.confirm_password = '';
				this.user.user_role_id = '';
				this.user.person_id = '';
			},
			user_submit(){
				let method = '';
				let message = '';
				if(this.user_edit === true){
					method = 'put';
					message = 'User updated.';
					this.user_edit = false;
				}else{
					method = 'post';
					message = 'User added.';
				}
				fetch('/api/user', {
					method: method,
					body: JSON.stringify(this.user),
					headers: { 'content-type': 'application/json' }
				})
				.then(res => res.json())
				.then(res => {
					if(res.errors){
						this.notification_alert('Warning!', res.errors);
					}else{
						this.notification_alert('Success!', message);
						this.users_fetch();
						this.user_reset();
					}
					$('#user_modal').modal('hide');
				})
				.catch(err => console.log(err));
			},
			user_update(user){
				this.user_edit = true;
				this.user.user_id = user.user_id;
				this.user.username = user.username;
				this.user.user_role_id = user.user_role_id;
				this.user.person_id = user.person_id;
			},
			user_delete(id){
				if(confirm('Are you sure you want to delete?')) {
					fetch('/api/user/'+id, {
						method: 'delete'
					})
					.then(res => res.json())
					.then(res => {
						this.notification_alert('Success!', 'User removed.');
						this.users_fetch();
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