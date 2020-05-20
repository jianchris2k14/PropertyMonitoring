<template>

<div class="card">

<!-- HEADER -->
<div class="card-header">
	Persons List
    <button class="btn btn-primary btn-sm float-right" @click="person_reset()" data-toggle="modal" data-target="#person_modal">
        <i class="fas fa-plus-circle"></i> Add Person
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
	<input class="form-control" type="text" placeholder="Keyword (Min. 2 Chars.)" v-model="keyword" @keydown.enter="persons_fetch()">
	&nbsp
	<button class="btn btn-primary btn-sm" @click="persons_fetch()">
		<i class="fas fa-search"></i> Search
	</button>
</div>
<div class="table-responsive">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="text-center">Fullname</th>
				<th class="text-center">Gender</th>
				<th class="text-center">Birthdate</th>
				<th class="text-center">Mobile</th>
				<th class="text-center">Email Address</th>
				<th class="text-center">Address</th>
				<th class="text-center">Action</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="person in persons" v-bind:key="person.person_id">
				<td> {{ person.lastname }}, {{ person.firstname }} {{ person.middlename }} </td>
				<td> {{ person.gender }} </td>
				<td> {{ dateformat(person.birthdate) }} </td>
				<td> {{ person.mobile }} </td>
				<td> {{ person.email_address }} </td>
				<td> {{ person.address }} </td>
				<td>
					<center>
						<button class="btn btn-info btn-sm" @click="person_update(person)" data-toggle="modal" data-target="#person_modal" style="width: 75px;">
							<i class="fas fa-edit"></i> Edit
						</button>
						<button class="btn btn-danger btn-sm" @click="person_delete(person.person_id)" style="width: 75px;"> 
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
		<a class="page-link" href="#" @click="persons_fetch(pagination.prev_page_url)"> 
			Previous <i class="fas fa-chevron-left"></i> 
		</a>
	</li>
	<li class="page-item disabled">
		<a class="page-link text-dark"> 
			Page {{ pagination.current_page }} of {{ pagination.last_page }}
		</a>
	</li>
	<li v-bind:class="[{ disabled: !pagination.next_page_url }]" class="page-item">
		<a class="page-link" href="#" @click="persons_fetch(pagination.next_page_url)"> 
			<i class="fas fa-chevron-right"></i> Next 
		</a>
	</li>
</ul>
<!-- END TABLE -->
</div>

<!-- MODAL -->
<div class="modal fade" id="person_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <p class="modal-title">Personal Information</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form @submit.prevent="person_submit()">
            	<div class="modal-body">
            	
            		<div class="row">
                		<div class="col">
                            
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Firstname" v-model="person.firstname" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Middlename" v-model="person.middlename">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Lastname" v-model="person.lastname" required>
                            </div>
                            <div class="form-group">
                                <select class="form-control" v-model="person.gender" required>
                                    <option value="">Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                            	<label>Birthdate</label>
                            	<input class="form-control" type="date" v-model="person.birthdate" required>
                            </div>

                        </div>
                        <div class="col">
                            
                            <div class="form-group">
                                <input class="form-control" type="number" placeholder="Mobile" v-model="person.mobile" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Email Address" v-model="person.email_address" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Address" rows="6" v-model="person.address"></textarea>
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
				persons: [],
				person: {
					person_id: '',
					firstname: '',
					middlename: '',
					lastname: '',
					gender: '',
					birthdate: '',
					address: '',
					mobile: '',
					email_address: '',
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
			this.persons_fetch();
		},
		methods: {
			dateformat(value){
				 return moment(String(value)).format('MM/DD/YYYY');
			},
			persons_fetch(page_url = '/api/persons'){
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
						this.persons = res.data;
						this.persons_pagination(res.meta, res.links);
					})
					.catch(err => console.log(err));
				}
			},
			persons_pagination(meta, links){
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
			person_reset(){
				this.edit = false;
				this.person.person_id = '';
				this.person.firstname = '';
				this.person.middlename = '';
				this.person.lastname = '';
				this.person.gender = '';
				this.person.birthdate = '';
				this.person.mobile = '';
				this.person.email_address = '';
				this.person.address = '';
			},
			person_submit(){
				let method = '';
				let message = '';
				if(this.edit === true){
					method = 'put';
					message = 'Person updated.';
					this.edit = false;
				}else{
					method = 'post';
					message = 'Person added.';
				}
				fetch('/api/person', {
					method: method,
					body: JSON.stringify(this.person),
					headers: { 'content-type': 'application/json' }
				})
				.then(res => res.json())
				.then(res => {
					if(res.errors){
						this.persons_alert('Warning!', res.errors);
					}else{
						this.persons_alert('Success!', message);
						this.persons_fetch();
						this.person_reset();
					}
					$('#person_modal').modal('hide');
				})
				.catch(err => console.log(err));
			},
			person_update(person){
				this.edit = true;
				this.person.person_id = person.person_id;
				this.person.firstname = person.firstname;
				this.person.middlename = person.middlename;
				this.person.lastname = person.lastname;
				this.person.gender = person.gender;
				this.person.birthdate = person.birthdate;
				this.person.mobile = person.mobile;
				this.person.email_address = person.email_address;
				this.person.address = person.address;
			},
			person_delete(id){
				if(confirm('Are you sure you want to delete?')) {
					fetch('/api/person/'+id, {
						method: 'delete'
					})
					.then(res => res.json())
					.then(res => {
						this.persons_alert('Success!', 'Person removed.');
						this.persons_fetch();
					})
					.catch(err => console.log(err));
				}
			},
			persons_alert(notification_type, notification_message){
				this.notification_type = notification_type;
				this.notification_message = notification_message;
				this.notification_show = true;
				setTimeout(() => this.notification_show = false, 5000);
			}
		}
	}
</script>