// CreateComponent.vue
<template>
	<div class="wrapper">
		<nav id="sidebar">
			<div class="sidebar-header">
				<h3>Orders</h3>
			</div>
			<ul class="list-unstyled components">
			</ul>
			<p class="total-price hidden">Total Price: </p>
			<ul class="list-unstyled CTAs">
				<li>
					<button v-on:click="placeOrder()">Place Order</button>
				</li>
			</ul>
			<p class="success-message hidden">Your order has been placed</p>
		</nav>
		<div class="product_grid">
			<ul class="product_list list">
				<li v-for="product in products" :key="product.id" v-bind:data-id="product.id" class="product_item">
					<div class="product_image">
						<div v-bind:style="{ backgroundImage: 'url(' + product.product_image + ')' }"> </div>
					</div>
					<div class="product_values">
						<div class="product_title">
							<h5>{{ product.product_name }}</h5>
						</div>
						<div class="product_price">
							<span class="price_new">{{ product.product_price }}</span>
						</div>
					</div>
					<button type="button" class="btn btn-primary" data-toggle="modal"  v-bind:data-target="`.product_${product.id}`"></button>
					<div class="modal fade" v-bind:class="`product_${product.id}`" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="popup-item">
									<div class="product_image">
										<div v-bind:style="{ backgroundImage: 'url(' + product.product_image + ')' }"> </div>
									</div>
									<div class="product_values">
										<div class="product_title">
											<h5>{{ product.product_name }}</h5>
											<div class="product_price">
												<span class="price_new">{{ product.product_price }}</span>
											</div>
										</div>
										<div class="product_description">
											<p>{{ product.product_description }}</p>
										</div>
										<form>
											<label for="quantity">Quantity:</label>
											<input type="number" id="quantity" name="quantity" min="1" value="1">
											<div>
												<button @click="addProduct(product, $event)">Checkout</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</template>
<script>
    export default {
		data() {
            return {
                products: [],
				selectedProducts: {},
				price: 0
            }
        },
		created() {
			this.axios
                .get('api/order/')
                .then(response => {
                    this.products = response.data;
                });
		},
		methods:{
			addProduct(product, e) {
				e.preventDefault();
				const quantity = parseInt(document.querySelector(`.product_${product.id} #quantity`).value, 10);

				if (this.selectedProducts[product.id]) {
					this.selectedProducts[product.id] += quantity;
				} else {
					this.selectedProducts[product.id] = quantity;
				}

				this.updateOrder(product, quantity);
			},

			updateOrder(product, quantity) {
				const id = product.id;
				const element = document.querySelector(`#product_${id}`);
				const totalPrice = document.querySelector('.total-price');

				if (element) {
					let quantity = parseInt(element.querySelector('.quantity').innerText, 10) + 1;
					element.querySelector('.quantity').innerText = quantity;
				} else {
					const li = document.createElement("li");
					li.id = `product_${id}`;
					li.innerHTML = `${product.product_name} x <span class="quantity">${quantity}</span>`;

					document.querySelector('.list-unstyled.components').appendChild(li);
				}

				this.price += parseInt(product.product_price.slice(0, -1), 10) * quantity;

				this.closePopup(product);

				totalPrice.classList.remove('hidden');
				totalPrice.innerText = `Total Price: ${this.price}$`;
			},

			async placeOrder() {
				this.axios
					.post('api/order/', { price: this.price, products: this.selectedProducts })
					.then(() => this.resetOrder());
			},

			resetOrder() {
				const totalPrice = document.querySelector('.total-price');
				const successMessage = document.querySelector('.success-message');
				const orderItems = document.querySelector('.list-unstyled.components');

				successMessage.classList.remove('hidden');
				totalPrice.classList.add('hidden');
				orderItems.innerHTML = '';
				this.selectedProducts = {};
				this.price = 0;
			},

			closePopup(product) {
				document.querySelector(`.modal.product_${product.id}`).classList.remove('show');
				document.body.classList.remove('modal-open');
				document.querySelector('.modal-backdrop ').remove();
			}
		}
    };
</script>