<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- ヘッダーセクション -->
    <div class="bg-white shadow-lg border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-6">
          <div class="flex items-center space-x-4">
            <NuxtLink
              to="/"
              class="inline-flex items-center px-4 py-2 text-gray-600 hover:text-gray-900 transition-colors duration-200"
            >
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
              </svg>
              戻る
            </NuxtLink>
            <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
              </svg>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
              読書ログ詳細
            </h1>
          </div>
          <div class="flex space-x-3">
            <NuxtLink
              v-if="book"
              :to="`/books/${book.id}/edit`"
              class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors duration-200"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
              </svg>
              編集
            </NuxtLink>
            <button
              v-if="book"
              @click="deleteBook"
              class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors duration-200"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
              </svg>
              削除
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- メインコンテンツ -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- ローディング状態 -->
      <div v-if="loading" class="flex justify-center items-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
        <span class="ml-3 text-lg text-gray-600">読み込み中...</span>
      </div>

      <!-- 詳細コンテンツ -->
      <div v-else-if="book" class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- ヘッダー部分 -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
          <h2 class="text-3xl font-bold text-white mb-2">{{ book.title }}</h2>
          <div class="flex items-center text-blue-100">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="text-lg">{{ formatDate(book.read_date) }}</span>
          </div>
        </div>

        <!-- 感想部分 -->
        <div class="p-8">
          <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              読書感想
            </h3>
            <div class="bg-gray-50 rounded-lg p-6">
              <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ book.impression }}</p>
            </div>
          </div>

          <!-- メタ情報 -->
          <div class="border-t border-gray-200 pt-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <h4 class="text-sm font-medium text-gray-500 mb-2">作成日</h4>
                <p class="text-gray-900">{{ formatDateTime(book.created_at) }}</p>
              </div>
              <div>
                <h4 class="text-sm font-medium text-gray-500 mb-2">更新日</h4>
                <p class="text-gray-900">{{ formatDateTime(book.updated_at) }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- エラー状態 -->
      <div v-else class="text-center py-20">
        <div class="w-24 h-24 mx-auto mb-6 bg-red-100 rounded-full flex items-center justify-center">
          <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">読書ログが見つかりません</h3>
        <p class="text-gray-500 mb-8">指定された読書ログが存在しないか、削除された可能性があります。</p>
        <NuxtLink
          to="/"
          class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
          </svg>
          ホームに戻る
        </NuxtLink>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  middleware: 'auth',
  data() {
    return {
      book: null,
      loading: true
    }
  },
  async fetch() {
    try {
      if (this.$auth) {
        const response = await this.$auth.apiRequest(`/api/books/${this.$route.params.id}`)
        this.book = response.book || null
      }
    } catch (error) {
      console.error('読書ログの取得に失敗しました:', error)
      this.book = null
    } finally {
      this.loading = false
    }
  },
  methods: {
    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString('ja-JP', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    },
    formatDateTime(dateString) {
      return new Date(dateString).toLocaleString('ja-JP', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      })
    },
    async deleteBook() {
      if (confirm('この読書ログを削除しますか？')) {
        try {
          if (this.$auth) {
            await this.$auth.apiRequest(`/api/books/${this.$route.params.id}`, { method: 'DELETE' })
            this.$router.push('/')
          }
        } catch (error) {
          console.error('削除に失敗しました:', error)
          alert('削除に失敗しました')
        }
      }
    }
  }
}
</script>
