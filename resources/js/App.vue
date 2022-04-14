// App.vue

<template>
  <nav class="navbar navbar-expand-sm navbar-light" style="background-color: #ffffff">
    <div class="container">
		<img
            width="150"
            height="20"
            src="https://www.foodics.com/wp-content/uploads/2021/12/foodics-logo.svg"
		/>
		<ul class="navbar-nav">
			<li class="nav-item">
				<p>Meals</p>
			</li>
			<li class="nav-item">
				<p>Snacks</p>
			</li>
			<li class="nav-item">
				<p>Supplements</p>
			</li>
			<li class="nav-item">
				<p>Shop All</p>
			</li>
		</ul>
    </div>
  </nav>
  <div class="container">
    <transition name="fade">
      <router-view></router-view>
    </transition>
  </div>
</template>

<style>
	.fade-enter-active,
	.fade-leave-active {
		transition: opacity 0.5s;
	}

	.fade-enter,
	.fade-leave-active {
		opacity: 0;
	}
</style>

<script>
	export default {};
</script>
