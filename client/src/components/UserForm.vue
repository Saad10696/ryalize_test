<template>
    <div class="modal fade" :class="{ show: isVisible }" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true"
        ref="modal" v-if="isVisible">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">{{ id ? 'Update' : 'Add' }} User</h5>
                    <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
                </div>
                <form action="" @submit="onSubmit">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="">Name</label>
                            <input type="text" v-model="name" name="name" class="form-control"
                                placeholder="Enter name here" required>
                        </div>
                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="email" v-model="email" name="email" class="form-control"
                                placeholder="Enter email here" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

const initialState = {
    isVisible: false,
    id: null,
    name: '',
    email: ''
}

export default {
    name: 'UserForm',
    data() {
        return { ...initialState }
    },
    methods: {
        closeModal() {
            Object.assign(this, { ...initialState });
        },
        onSubmit(e) {
            e.preventDefault();
            if (this.id) {
                axios.put(`users/${this.id}`, {
                    name: this.name,
                    email: this.email
                }).then(res => {
                    this.closeModal()
                    this.$emit('updateExisting', res.data)
                }).catch(err => console.log(err))
            } else {
                axios.post(`users`, {
                    name: this.name,
                    email: this.email
                }).then(res => {
                    this.closeModal()
                    this.$emit('addNew', res.data)
                }).catch(err => console.log(err))
            }
        },
        setData(data) {
            Object.assign(this, {
                id: data.id,
                name: data.name,
                email: data.email
            });
        }
    }
}
</script>


<style scoped>
.modal {
    display: block;
    /* Ensures modal takes space */
    opacity: 0;
    background-color: #00000033;
}

.modal.show {
    opacity: 1;
    transition: opacity 0.3s ease;
}
</style>