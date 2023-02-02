<template>
    <div>
        <h1>Create Tag</h1>
        <form @submit.prevent="addPostTag">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label> Name</label>
                        <input type="text"
                               class="form-control"
                               v-model="tag.name"
                               v-bind:class="{' is-invalid ' : errors.name}"
                        >
                        <div class="invalid-feedback" v-if="errors.name">{{ errors.name }}</div>
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
            tag: {},
            errors: {
                name : ''
            }

        }
    },

    methods: {
        addPostTag(){
            let uri = 'http://127.0.0.1:8000/api/tag/create'
            axios
                .post(uri, this.tag)
                .then(response => {
                    if(response.data.code === 500){
                        this.errors = {
                            name : ''
                        }
                        if(!this.tag.name){
                            this.errors.name = "Name không được để trống"
                        }
                    }
                    if(response.data.code === 200){
                        this.$router.push({name: 'tag'})
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



