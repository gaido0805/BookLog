<template>
  <div class="max-w-2xl mx-auto">
    <div class="mb-6">
      <h1 class="text-3xl font-bold">読書ログ新規登録</h1>
    </div>

    <form @submit.prevent="createBook" class="space-y-6">
      <div>
        <label for="title" class="block text-sm font-medium text-gray-700">タイトル</label>
        <input
          id="title"
          v-model="form.title"
          type="text"
          required
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
          placeholder="本のタイトルを入力してください"
        >
      </div>

      <div>
        <label for="read_date" class="block text-sm font-medium text-gray-700">読んだ日</label>
        <input
          id="read_date"
          v-model="form.read_date"
          type="date"
          required
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        >
      </div>

      <div>
        <label for="impression" class="block text-sm font-medium text-gray-700">感想</label>
        <textarea
          id="impression"
          v-model="form.impression"
          rows="6"
          required
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
          placeholder="読んだ感想を入力してください"
        ></textarea>
      </div>

      <div class="flex space-x-4">
        <button
          type="submit"
          :disabled="loading"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
        >
          {{ loading ? '登録中...' : '登録' }}
        </button>
        <NuxtLink
          to="/"
          class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
        >
          キャンセル
        </NuxtLink>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  middleware: 'auth',
  data() {
    return {
      form: {
        title: '',
        read_date: new Date().toISOString().split('T')[0],
        impression: ''
      },
      loading: false
    }
  },
  methods: {
    async createBook() {
      this.loading = true
      try {
        await this.$axios.post('/books', this.form)
        this.$router.push('/')
      } catch (error) {
        console.error('読書ログの作成に失敗しました:', error)
        alert('読書ログの作成に失敗しました。入力内容を確認してください。')
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
