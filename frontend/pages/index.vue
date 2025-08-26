<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">読書ログ一覧</h1>
      <NuxtLink
        to="/books/create"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        新規登録
      </NuxtLink>
    </div>

    <div v-if="loading" class="text-center py-8">
      <p>読み込み中...</p>
    </div>

    <div v-else-if="books.length === 0" class="text-center py-8">
      <p class="text-gray-500">読書ログがありません</p>
      <NuxtLink
        to="/books/create"
        class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        最初の読書ログを登録する
      </NuxtLink>
    </div>

    <div v-else class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
      <div
        v-for="book in books"
        :key="book.id"
        class="bg-white border rounded-lg shadow-md p-6"
      >
        <h3 class="text-xl font-semibold mb-2">{{ book.title }}</h3>
        <p class="text-gray-600 mb-2">読んだ日: {{ formatDate(book.read_date) }}</p>
        <p class="text-gray-800 mb-4">{{ book.impression }}</p>
        <div class="flex space-x-2">
          <NuxtLink
            :to="`/books/${book.id}/edit`"
            class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700"
          >
            編集
          </NuxtLink>
          <button
            @click="deleteBook(book.id)"
            class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700"
          >
            削除
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  middleware: 'auth',
  data() {
    return {
      books: [],
      loading: true
    }
  },
  async fetch() {
    try {
      const response = await this.$axios.get('/books')
      this.books = response.data.books
    } catch (error) {
      console.error('読書ログの取得に失敗しました:', error)
    } finally {
      this.loading = false
    }
  },
  methods: {
    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString('ja-JP')
    },
    async deleteBook(id) {
      if (confirm('この読書ログを削除しますか？')) {
        try {
          await this.$axios.delete(`/books/${id}`)
          this.books = this.books.filter(book => book.id !== id)
          this.$toast.success('読書ログを削除しました')
        } catch (error) {
          console.error('削除に失敗しました:', error)
          this.$toast.error('削除に失敗しました')
        }
      }
    }
  }
}
</script>
