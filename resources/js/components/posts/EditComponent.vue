<template>
    <div>
        <h1>Edit Post</h1>
        <form @submit.prevent="updatePost">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Post Title:</label>
                        <input type="text"
                                class="form-control"
                                v-model="post.title"
                                v-bind:class="{' is-invalid ' : errors.title}"
                        >
                        <div class="invalid-feedback" v-if="errors.title">{{ errors.title }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Post Body:</label>
                        <textarea class="form-control"
                                  v-model="post.body"
                                  rows="5"
                                  v-bind:class="{' is-invalid ' : errors.body}"
                        >
                        </textarea>
                        <div class="invalid-feedback" v-if="errors.body">{{ errors.body }}</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label >Choose tag</label> <br>
                        <Select2 v-model="post.tag_ids"
                                 :options="tag"
                                 :settings="{  multiple: true }"
                                 @select="getTag($id,$index)"
                        />
                    </div>
                </div>
            </div><br />
            <div class="form-group">
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</template>

<script>
import Select2 from 'vue3-select2-component'
export default {
    components: {Select2 },
    data() {
        return {
            post: {},
            tag: [],
            tag_id:[],
            errors: {
                title: "",
                body: ""
            },
        }
    },
    created() {
        let uri = `http://127.0.0.1:8000/api/posts/edit/${this.$route.params.id}`;
        axios
            .get(uri)
            .then((response) => {
                this.post = response.data.post
            });
        this.showTag()
    },
    methods: {
        getTag(id,index){
            if(!this.post.tag_ids){
                this.post.tag_ids = []
            }
            if(this.post.tag_ids[index].id === id){
                return true
            }else{
                return false
            }
        },
        showTag(){
            let uri = 'http://127.0.0.1:8000/api/tag';
            axios
                .get(uri)
                .then(response => {
                    this.tag = response.data.data
                });
        },
        updatePost() {
            let uri = `http://127.0.0.1:8000/api/posts/update/${this.$route.params.id}`;
            axios
                .put(uri, this.post)
                .then((response) => {
                    if(response.data.code === 500){
                        this.errors = {
                            title: "",
                            body: ""
                        }
                        if(!this.post.title){
                            this.errors.title = "Title không được để trống"

                        }
                        if(!this.post.body){
                            this.errors.body = "Body không được để trống"
                        }
                    }
                    if(response.data.code === 200){
                        this.$router.push({name: 'posts'})
                        // sweetalert
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        Toast.fire({
                            icon: 'success',
                            title: 'update thành công'
                        })
                    }
            });
        },
    }
}
</script>
