<template>
    <div>
<!--        <input type="text" placeholder="your search" v-model="search" class="form-control-lg offset-8">-->
        <h1>List post</h1>
        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <router-link :to="{ name: 'create' }" class="btn btn-primary">Create Post</router-link>
            </div>
        </div>
        <br />

        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th> Title</th>
                <th> Body</th>
                <th>TagName</th>
                <th>Actions</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="post in posts.data" :key="post.id">
                <td>{{ post.id }}</td>
                <td>{{ post.title }}</td>
                <td>{{ post.body }}</td>
                <td>
                    <span v-for="tag in post.tags" :key="tags.id" >
                        <router-link :to="{name: 'editTag', params: { id: tag.id }}" >{{tag.name}}</router-link>
                    </span>
                </td>
                <td>
                    <router-link :to="{name: 'edit', params: { id: post.id }}" class="btn btn-primary">Edit</router-link>
                </td>
                <td>
                    <button class="btn btn-danger" @click.prevent="deletePost(post.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <!--        Pagination-->
        <Pagination
            :data="posts"
            @pagination-change-page="showPost"
        />
    </div>
</template>

<script>
import LaravelVuePagination from 'laravel-vue-pagination';
export default {
    components:{
        'Pagination': LaravelVuePagination
    },
    data() {
        return {
            posts: [],
            search: '',
            tags : []
        }
    },
    created() {
        this.showPost()
        this.showTag()
    },
    methods: {
        showPost(page=1){
            let uri = 'http://127.0.0.1:8000/api/posts?page='+page;
            axios
                .get(uri)
                .then(response => {
                    this.posts = response.data;
                });
        },
        showTag(){
            let uri = 'http://127.0.0.1:8000/api/tag';
            axios
                .get(uri)
                .then(response => {
                    this.tags = response.data.data;
                });
        },
        deletePost(id) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa không',
                text: "Bạn sẽ không thể khôi phục khi xóa",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xóa'
            }).then((result) => {
                if(!result.isConfirmed){
                    return false
                }else{
                    let uri = `http://127.0.0.1:8000/api/posts/delete/${id}`;
                    axios
                        .delete(uri)
                        .then(response=>{
                            let tagItem = this.posts.filter(item => item.id == id);
                            this.posts.splice(this.posts.indexOf(tagItem[0]), 1);
                        })
                    Swal.fire(
                        'Xóa thành công!',
                        'Bạn đã xóa thành công',
                        'success'
                    )
                }
            })
        },
        searchData(value){
            let uri = 'http://127.0.0.1:8000/api/posts/search/'+value
            axios
                .get(uri)
                .then(response => {
                    this.posts = response.data;
                });
        }
    },

    watch:{
        search(){
            this.searchData(this.search)
        }
    },
}

</script>
<style>
a{
    margin-right: 10px;
}
</style>
