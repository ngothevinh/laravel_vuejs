<template>
    <div>
        <h1>List Tag</h1>
        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <router-link :to="{ name: 'createTag' }"  class="btn btn-primary">Create Tag</router-link>
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
            <tr v-for="tag in tag" :key="tag.id">
                <td>{{ tag.id }}</td>
                <td>{{ tag.name }}</td>
                <td><router-link :to="{name: 'editTag', params: { id: tag.id }}" class="btn btn-primary">Edit</router-link></td>
                <td><button class="btn btn-danger" @click.prevent="deleteTag(tag.id)">Delete</button></td>
            </tr>
            </tbody>
        </table>
    </div>

</template>

<script>

export default {

    data() {
        return {
            tag: [],
            posts: [],
            post_ids: []

        }
    },
    computed: {
        //search
        // filterPost(){
        //     return this.posts.filter(post => post.title.includes(this.search))
        // }
    },
    created() {
        this.showTag()
    },
    methods: {
        showTag(){
            let uri = 'http://127.0.0.1:8000/api/tag';
            axios
                .get(uri)
                .then(response => {
                    this.tag = response.data.data;
                });
        },
        deleteTag(id) {
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
                    let uri = `http://127.0.0.1:8000/api/tag/delete/${id}`;
                    axios
                        .delete(uri)
                        .then(response=>{
                            if(response.data.code == 400){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi',
                                    text: 'Xóa không thành công do tag này đang nằm trong 1 post khác',
                                })
                            }
                            else{
                                let tagItem = this.tag.filter(item => item.id == id);
                                this.tag.splice(this.tag.indexOf(tagItem[0]), 1);
                                Swal.fire(
                                    'Xóa thành công!',
                                    'Bạn đã xóa thành công',
                                    'success'
                                )
                            }
                        })
                }
            })
        },
    },
}

</script>
