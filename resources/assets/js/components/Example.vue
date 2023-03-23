<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        <template>
                            <input type="text" v-model="postBody" @change="postPost()"/>
                            <ul v-if="errors && errors.length">
                                <li v-for="error of errors">
                                    {{error.message}}
                                </li>
                            </ul>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	import axios from 'axios';
	import moment from 'moment';

	export default {
		data: () => ({
			posts: [],
			errors: []
		}),

		// Fetches posts when the component is created.
		created() {
			console.log(moment().format())
			axios.get('http://jsonplaceholder.typicode.com/posts')
				.then(response => {
					// JSON responses are automatically parsed.
					this.posts = response.data
                    console.log(response.data)
				})
				.catch(e => {
					this.errors.push(e)
				})

		}
	}
</script>
