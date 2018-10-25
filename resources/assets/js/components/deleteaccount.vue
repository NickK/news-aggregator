<template>
	<div class="deleteaccount">
        <form @submit="deleteAccount" v-bind:action="route" method="post">
        	<input type="hidden" name="delete" value="1">
        	<input type="hidden" name="_token" v-bind:value="token">
            <button class="btn">{{label}}</button>
        </form>
	</div>
</template>

<script>
export default {
	name: 'deleteaccount',
	props: ['routeData'],
	data() {
		return {
			route: '',
			token: window.Laravel['csrfToken'],
			label: 'Delete Account'
		}
	},
	created() {
		// Route needs to be added to action
		this.route = this.routeData;
	},
	methods: {
		deleteAccount(e) {
			 var confirm = prompt("Are you sure you want to delete your account? (To confirm write: DELETE ACCOUNT)");
			 if (confirm !== 'DELETE ACCOUNT') {
			 	e.preventDefault();
			 }
		}
	}
};
</script>