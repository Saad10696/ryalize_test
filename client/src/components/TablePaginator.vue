<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <a :class="[
                    'page-link',
                    active == 1 ? 'disabled' : ''
                ]" @click="$emit('btnClicked', active - 1)" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li :class="['page-item', active == (index + 1) ? 'active': '']" :key="index" v-for="(_, index) in Array(total).fill({})">
                <a class="page-link" @click="$emit('btnClicked', index + 1)">{{index + 1}}</a>
            </li>
            <li class="page-item">
                <a :class="[
                    'page-link',
                    active == total ? 'disabled' : ''
                ]" @click=" $emit('btnClicked', active + 1)" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: 'TablePaginator',
    components: {},
    props: ['total', 'active']
}
</script>

<style scoped>
.pagination {
    overflow-x: auto;
    white-space: nowrap;
    padding-bottom: 5px; /* Optional, to add a bit of space below */
}
</style>