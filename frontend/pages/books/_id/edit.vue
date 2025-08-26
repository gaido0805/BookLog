<template>
  <div class="max-w-2xl mx-auto">
    <div class="mb-6">
      <h1 class="text-3xl font-bold">読書ログ編集</h1>
    </div>

    <div v-if="loading" class="text-center py-8">
      <p>読み込み中...</p>
    </div>

    <form v-else @submit.prevent="updateBook" class="space-y-6">
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
          :disabled="updating"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
        >
          {{ updating ? '更新中...' : '更新' }}
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
        read_date: '',
        impression: ''
      },
      loading: true,
      updating: false
    }
  },
  async fetch() {
    try {
      const response = await this.$axios.get(`/books/${this.$route.params.id}`)
      const book = response.data.book
      this.form = {
        title: book.title,
        read_date: book.read_date,
        impression: book.impression
      }
    } catch (error) {
      console.error('読書ログの取得に失敗しました:', error)
      this.$router.push('/')
    } finally {
      this.loading = false
    }
  },
  methods: {
    async updateBook() {
      this.updating = true
      try {
        await this.$axios.put(`/books/${this.$route.params.id}`, this.form)
        this.$router.push('/')
      } catch (error) {
        console.error('読書ログの更新に失敗しました:', error)
        alert('読書ログの更新に失敗しました。入力内容を確認してください。')
      } finally {
        this.updating = false
      }
    }
  }
}
</script>
