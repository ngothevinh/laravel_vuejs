<template>
    <div>
        <h1>List Category</h1>
        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <router-link :to="{ name: 'createCategory' }"  class="btn btn-primary">Create Category</router-link>
            </div>
        </div>
        <br />

        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="category in category" :key="category.id">
                <td>{{ category.id }}</td>
                <td>{{ category.name }}</td>
                <td><router-link :to="{name: 'editCategory', params: { id: category.id }}" class="btn btn-primary">Edit</router-link></td>
                <td><button class="btn btn-danger" @click.prevent="deleteCategory(category.id)">Delete</button></td>
            </tr>
            </tbody>
        </table>

    </div>

</template>

<script>

export default {

    data() {
        return {
            category: [],

        }
    },
    computed: {
        //search
        // filterPost(){
        //     return this.posts.filter(post => post.title.includes(this.search))
        // }

    },
    created() {
        this.showUser()
    },
    methods: {
        showUser(){
            let uri = 'http://127.0.0.1:8000/api/category';
            axios
                .get(uri)
                .then(response => {
                    this.category = response.data.data;
                });
        },

        deleteCategory(id) {
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
                    let uri = `http://127.0.0.1:8000/api/category/delete/${id}`;
                    axios
                        .delete(uri)
                        .then(response=>{
                            this.posts.splice(this.category.indexOf(id), 1);
                        })
                    Swal.fire(
                        'Xóa thành công!',
                        'Bạn đã xóa thành công',
                        'success'
                    )
                }
            })
        },
    },
}

</script>
