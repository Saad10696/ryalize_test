<template>
  <div class="container">
    <UserForm ref="formRef" @addNew="addNew" @updateExisting="updateExisting" />
    <TransactionList ref="transactionRef" @addNew="addNew" @updateExisting="updateExisting" />
    <div class="mb-2 text-end">
      <button class="btn btn-primary btn-sm" @click="toggleForm">+ Add User</button>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Sr.no</th>
          <th>Name</th>
          <th>Email</th>
          <th>Created on</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr :key="user.id" v-for="user in users">
          <td>{{ user.id }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.created_at }}</td>
          <td>
            <i class="fas fa-edit me-3" @click="onEdit(user)"></i>
            <i class="fas fa-trash text-danger" @click="deleteUser(user.id)"></i>
            <i class="fas fa-list ms-3" @click="onTrasactions(user.id)"></i>
          </td>
        </tr>
        <tr v-if="users.length == 0">
          <td colspan="5" class="text-center">No Records Found</td>
        </tr>
      </tbody>
    </table>
    <TablePaginator :total="total" :active="active" @btnClicked="getUsers" />
  </div>


</template>

<script>
import axios from 'axios';
import TablePaginator from './components/TablePaginator.vue';
import UserForm from './components/UserForm.vue';
import TransactionList from './components/TransactionList.vue';

export default {
  name: 'App',
  data() {
    return {
      users: [],
      total: 10,
      active: 1,
      showForm: false
    }
  },
  components: {
    TablePaginator,
    UserForm,
    TransactionList
  },
  methods: {
    getUsers(page = 1) {
      axios.get(`users`, {
        params: { page }
      }).then((res) => {
        const { data, current_page, last_page } = res.data;
        this.users = data;
        this.active = current_page;
        this.total = last_page;
      }).catch(err => console.error(err))
    },
    toggleForm() {
      this.$refs.formRef.isVisible = true
    },
    addNew(user) {
      this.users = [...this.users, user]
    },
    updateExisting(user) {
      this.users = this.users.map(i => i.id == user.id ? { ...user } : i)
    },
    onEdit(data) {
      this.$refs.formRef.isVisible = true
      this.$refs.formRef.setData(data);
    },
    deleteUser(id) {
      const ans = confirm('Are you sure, you want to delete this user?')
      if (ans) {
        axios.delete(`users/${id}`).then((res) => {
          if (res.status < 300) {
            this.users = this.users.filter(i => i.id != id);
          }
        }).catch(err => console.error(err))
      }
    },
    onTrasactions(user_id) {
      this.$refs.transactionRef.user_id = user_id
      this.$refs.transactionRef.isVisible = true
    },
  },
  mounted() {
    this.getUsers()
  },
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  /* text-align: center; */
  color: #2c3e50;
  margin-top: 60px;
}
</style>
