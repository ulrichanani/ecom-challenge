<template>
    <tr>
        <td>{{ product.name }}</td>
        <td>{{ product.description }}</td>
        <td>{{ product.price }}</td>
        <td>{{ product.discounted_price }}</td>
        <td>{{ product.display === 0 ? 'Default' : 'Featured' }}</td>
        <td class="actions">
            <div>
                <a class="btn btn-primary btn-sm mb-1"
                   v-bind:href="`${this.$urlPrefix}admin/products/${product.product_id}/edit`">
                    Edit</a>
                <!--<button class="btn btn-primary btn-sm mb-1" @click="editRecord">Edit</button>-->
                <!--<button class="btn btn-danger btn-sm mb-1" @click="deleteRecord">Delete</button>-->
            </div>
        </td>
    </tr>
</template>

<script>
    export default {
        props: {
            product: {
                product_id: Number,
                name: String,
                description: String,
                price: Number,
                discounted_price: Number,
                display: Number
            },

        },

        created() {

        },

        methods: {
            /*deleteRecord() {
                if(!confirm('Are you sure?'))
                    return

                axios.delete(this.base_url + this.product.product_id)
                    .then(res => {
                        this.show = false
                        toastr.success('Category deleted succefully !')
                    })
                    .catch(err => console.log(err))
            },*/

            /*editRecord() {
                this.$emit('editClicked', this.product)
            }*/
        }
    }
</script>
