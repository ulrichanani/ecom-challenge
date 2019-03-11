<template>
    <tr>
        <td>{{ order.reference }}</td>
        <td>{{ order.customer.name }}</td>
        <td>{{ order.total_amount }}</td>
        <td>{{ order.created_on }}</td>
        <td>{{ getStatus(order.status) }}</td>
        <td class="actions">
            <div>
                <a class="btn btn-primary btn-sm mb-1"
                   v-bind:href="`${this.$urlPrefix}admin/orders/${order.order_id}`">
                    Show details</a>
                <!--<button class="btn btn-primary btn-sm mb-1" @click="editRecord">Edit</button>-->
                <!--<button class="btn btn-danger btn-sm mb-1" @click="deleteRecord">Delete</button>-->
            </div>
        </td>
    </tr>
</template>

<script>
    export default {
        props: {
            order: {
                order_id: Number,
                reference: String,
                customer: Object,
                customer_id: String,
                total_amount: Number,
                created_on: Number,
                status: Number
            }
        },

        methods: {
            getStatus(val) {
                switch(val) {
                    case 1:
                        return 'Not Shipped'
                    case 2:
                        return 'Shipped'
                    case 3:
                        return 'Cancelled'
                }
            },
        }
    }
</script>
