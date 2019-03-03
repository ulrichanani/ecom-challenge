<template>
    <tr v-if="show">
        <td>{{ attributeValue.value }}</td>
        <td class="actions">
            <div>
                <button class="btn btn-primary btn-sm mb-1" @click="editRecord">Edit</button>
                <button class="btn btn-danger btn-sm mb-1" @click="deleteRecord">Delete</button>
            </div>
        </td>
    </tr>
</template>

<script>
    export default {
        props: {
            attributeValue: {
                attribute_value_id: Number,
                attribute_id: Number,
                value: String,
            }
        },

        data() {
            return {
                base_url: String,
                show: true
            }
        },

        created() {
            this.base_url = `/admin/attributes/${this.attributeValue.attribute_id}/values/`
        },

        methods: {
            deleteRecord() {
                if(!confirm('Are you sure?'))
                    return

                axios.delete(this.base_url + this.attributeValue.attribute_value_id)
                    .then(res => {
                        this.show = false
                        this.flashMessage.success({message: 'Attibute value deleted succefully !'})
                    })
                    .catch(err => console.log(err))
            },

            editRecord() {
                this.$emit('edit', this.attributeValue)
            }
        }
    }
</script>
