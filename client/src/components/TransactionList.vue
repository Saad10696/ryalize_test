<template>
    <div class="modal fade" :class="{ show: isVisible }" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true"
        ref="modal" v-if="isVisible">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">User Transactions</h5>
                    <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="">Date</label>
                                <input type="date" v-model="date" name="name" class="form-control"
                                    placeholder="Enter name here" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="">Type</label>
                                <select v-model="type" name="type" class="form-control"
                                    placeholder="Select a type">
                                    <option value="credit">Credit</option>
                                    <option value="debit">Debit</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="">Location</label>
                                <select v-model="location_id" name="location" class="form-control"
                                    placeholder="Select a location">
                                    <option value="" selected>Select a location</option>
                                    <option :value="loc.id" :key="loc.id" v-for="loc in locations">{{ loc.city }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 text-end  ">
                            <button class="btn btn-primary btn-sm" @click="getTransactions(1)">Get Records</button>
                        </div>
                    </div>

                    <table class="table table-bordered mt-4">
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Created On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :key="transaction.id" v-for="transaction in transactions">
                                <td>{{ transaction.amount }}</td>
                                <td>{{ transaction.type }}</td>
                                <td>{{ moment(transaction.created_at).format('lll') }}</td>
                            </tr>
                            <tr v-if="transactions.length == 0">
                                <td colspan="3" class="text-center">No Records Found</td>
                            </tr>
                        </tbody>
                    </table>
                    <TablePaginator :total="total" :active="active" @btnClicked="getTransactions" />

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import TablePaginator from './TablePaginator.vue';

const initialState = {
    isVisible: false,
    user_id: null,
    location_id: null,
    type: null,
    date: null,
    transactions: [],
    locations: [],
    total: 0,
    active: 1
}

export default {
    name: 'TransactionList',
    data() {
        return { ...initialState }
    },
    components: {
        TablePaginator
    },
    mounted() {
        this.getLocations()
    },
    methods: {
        moment(date) {
            return moment(date);
        },
        closeModal() {
            Object.assign(this, { ...initialState });
        },
        getTransactions(page = 1) {
            axios.get(`transactions`, {
                params: {
                    page,
                    user_id: this.user_id,
                    ...( this.location_id && {location_id: this.location_id}),
                    ...( this.type && {type: this.type}),
                    ...( this.date && {date: this.date}),
                }
            }).then(res => {
                if (res.status < 300) {
                    const { data, current_page, last_page } = res.data;
                    this.transactions = data
                    this.active = current_page;
                    this.total = last_page;
                }
            }).catch(err => console.error(err))
        },
        getLocations(){
            axios.get(`locations`).then(res => {
                this.locations = res.data;
            }).catch(err => console.error(err))
        }
    }
}
</script>

<style scoped>
.modal {
    display: block;
    opacity: 0;
    background-color: #00000033;
}

.modal.show {
    opacity: 1;
    transition: opacity 0.3s ease;
}
</style>