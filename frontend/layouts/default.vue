<template>
  <div>
    <nav class="bg-blue-600 text-white p-4">
      <div class="container mx-auto flex justify-between items-center">
        <NuxtLink to="/" class="text-xl font-bold">BookLog</NuxtLink>
        <div v-if="isAuthenticated" class="flex items-center space-x-4">
          <button @click="logout" class="hover:text-blue-200">ログアウト</button>
        </div>
        <div v-else>
          <NuxtLink to="/login" class="hover:text-blue-200">ログイン</NuxtLink>
          <NuxtLink to="/register" class="ml-4 hover:text-blue-200">新規登録</NuxtLink>
        </div>
      </div>
    </nav>
    <main class="container mx-auto p-4">
      <Nuxt />
    </main>
  </div>
</template>

<script>
export default {
  computed: {
    isAuthenticated() {
      return this.$auth ? this.$auth.isAuthenticated() : false
    }
  },
  methods: {
    async logout() {
      if (this.$auth) {
        await this.$auth.logout()
      }
      this.$router.push('/login')
    }
  }
}
</script>
