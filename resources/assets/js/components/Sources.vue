<template>
	<div>
		<span v-for="(source, index) in sources" :key="index" >
			<input type="checkbox" name="sources" v-on:change="checkBox(index)" v-model="source.active" :id="'id_'+ index +'_a'" :checked="source.active" :key="source.sourceID" /><label :for="'id_'+index+'_a'">{{source.sourceName}}</label>
		</span>
	</div>
</template>

<script>
export default {
	name: 'sources',
	data() {
		return {
			sources: [],
		}
	},
	methods: {
		checkBox(index) {
			this.$http.post(site_url + '/api/settings/sources/update', { sourceID: this.sources[index].sourceID, active: this.sources[index].active, _token: window.Laravel['csrfToken']});
			console.log(this.sources[index].active);
		}

	},
	created: function() {
		this.$http.get(site_url + '/api/settings/sources')
		.then(function(response) {
			this.sources = response.data.data;
		});
	}
};
</script>