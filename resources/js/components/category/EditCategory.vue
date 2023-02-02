<template>
    <div>
        <h1>Edit Category</h1>
        <form @submit.prevent="updateCategory">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text"
                               class="form-control"
                               v-model="category.name"
                        >
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Update</button>
            </div>

        </form>
    </div>
</template>

<script>
export default {

    data() {
        return {
            category: {},

        }
    },
    created() {
        let uri = `http://127.0.0.1:8000/api/category/edit/${this.$route.params.id}`;
        axios
            .get(uri)
            .then((response) => {
                this.category = response.data.category
                console.log(response.data.category)
            });
    },

    methods: {
        updateTag() {
            let uri = `http://127.0.0.1:8000/api/category/update/${this.$route.params.id}`;
            axios
                .put(uri, this.category)
                .then((response) => {
                    if(response.data.code === 200){
                        console.log(response.data);
                        this.$router.push({name: 'category'});
                        // sweetalert
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        Toast.fire({
                            icon: 'success',
                            title: 'Update thành công'
                        })
                    }
                });
        },
    }
}
</script>
