<template>
    <div class="calculate_shoping_area mt-0">
        <h3 class="cart_single_title">Calculate Shoping <span><i class="icon_minus-06"></i></span></h3>
        <div class="calculate_shop_inner">
            <form class="calculate_shoping_form row" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
                <div class="form-group col-lg-12">
                    <label for="shippingRegion">Shipping Region</label>
                    <select id="shippingRegion" class="form-control" v-model="selectedRegion" required
                        @change="regionChanged" >
                        <option v-for="region in regions" :key="region.shipping_region_id" v-bind:value="region.shipping_region_id">
                            {{ region.shipping_region }}
                        </option>
                    </select>
                </div>
                <div class="form-group col-lg-12">
                    <label for="shippingRegion">Shipping Type</label>
                    <select id="shippingType" class="form-control" v-model="selectedType" required
                        @change="typeChanged">
                        <option v-for="(type, index) in regionTypes" :key="type.shipping_id"
                                v-bind:value="type">
                            {{ type.shipping_type }}
                        </option>
                    </select>
                </div>
            </form>

            <input type="hidden" name="shipping_id" v-model="selectedType.shipping_region_id">
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            regions: Array,
            types: Array,
            userRegion: Number
        },

        data() {
            return {
                regionTypes: [],
                selectedRegion: 1,
                selectedType: '',
                region: {
                    shipping_region_id: Number,
                    shipping_region: String
                },
                type: {
                    shipping_id: Number,
                    shipping_region_id: Number,
                    shipping_type: String,
                    shipping_cost: String
                },
                emptyType: {
                    shipping_id: 0,
                    shipping_region_id: 0,
                    shipping_type: '',
                    shipping_cost: ''
                },
                subtotalAmount : 0,
            }
        },

        created() {
            console.log('created');

            this.subtotalAmount = document.getElementById('cartSubtotal').innerText
            this.subtotalAmount = this.subtotalAmount.replace('$', '')
            this.subtotalAmount = this.parseToFloat(this.subtotalAmount)
        },

        mounted() {
            console.log('mounted');
            this.selectedRegion = this.userRegion;
            this.loadRegionTypes()
            this.calculateShipping()
            // this.selectedType = this.regionTypes[0];
        },

        methods: {
            regionChanged() {
                this.regionTypes = []
                if(this.selectedRegion === 1) {
                    this.regionTypes[0] = this.emptyType
                } else {
                    this.loadRegionTypes()
                }
                this.selectedType = this.regionTypes[0]
                this.typeChanged()
            },

            typeChanged() {
                this.calculateShipping()
            },

            parseToFloat(nb) {
                let amount = Number.parseFloat(nb)
                if (Number.isNaN(amount)) {
                    amount = 0;
                }
                return amount
            },

            log(v) {
                console.log(v);
            },

            loadRegionTypes() {
                this.regionTypes = this.types.filter(t => t.shipping_region_id === this.selectedRegion)
            },

            calculateShipping() {
                let shippingAmount = this.parseToFloat(this.selectedType.shipping_cost)
                if(shippingAmount < 0.0001) {
                    document.getElementById('shippingAmount').innerText = 'Free'
                    document.getElementById('cartTotal').innerText = '' + this.subtotalAmount
                } else {
                    document.getElementById('shippingAmount').innerText = shippingAmount
                    let total = shippingAmount + this.subtotalAmount
                    document.getElementById('cartTotal').innerText = total.toFixed(2)
                }
            }
        }
    }
</script>
