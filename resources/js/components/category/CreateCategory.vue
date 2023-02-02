<template>
    <div>
        <h1>Create Category</h1>
        <form @submit.prevent="addPostCategory">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label> Name</label>
                        <input type="text"
                               class="form-control"
                               v-model="category.name"
                        >
                    </div>
                </div>
            </div>

            <br />
            <div class="form-group">
                <button class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data(){
        return {
            category: {},

        }
    },

    methods: {
        addPostCategory(){
            let uri = 'http://127.0.0.1:8000/api/category/create'
            axios
                .post(uri, this.category)
                .then(response => {
                // this.$router.push({name: 'category'})
                    if(response.data.code === 200){
                        this.$router.push({name: 'category'})
                        //          //sweetalert
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
                            title: 'Thêm mới thành công'
                        })
                    }
            })
        }
    }
}
</script>



