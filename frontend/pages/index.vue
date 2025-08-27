<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- ヘッダーセクション -->
    <div class="bg-white shadow-lg border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-6">
          <div class="flex items-center space-x-4">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
              </svg>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
              読書ログ一覧
            </h1>
          </div>
          <NuxtLink
            to="/books/create"
            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg shadow-lg hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            新規登録
          </NuxtLink>
        </div>
      </div>
    </div>

    <!-- メインコンテンツ -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- ローディング状態 -->
      <div v-if="loading" class="flex justify-center items-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
        <span class="ml-3 text-lg text-gray-600">読み込み中...</span>
      </div>

      <!-- 空の状態 -->
      <div v-else-if="books.length === 0" class="text-center py-20">
        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
          <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">読書ログがありません</h3>
        <p class="text-gray-500 mb-8">最初の読書ログを登録して、あなたの読書体験を記録しましょう</p>
        <NuxtLink
          to="/books/create"
          class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg shadow-lg hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          最初の読書ログを登録する
        </NuxtLink>
      </div>

      <!-- 読書ログ一覧 -->
      <div v-else>
        <!-- 統計情報 -->
        <div class="w-1/3 mb-6 bg-white rounded-lg shadow-sm border border-gray-100 p-2">
          <div class="flex items-center justify-center">
            <div class="text-md text-gray-500 font-medium">総ログ数：</div>
            <div class="text-md font-semibold text-blue-600">{{ totalBooks }}</div>
          </div>
        </div>

        <!-- 読書ログカード -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-2">
          <div
            v-for="book in paginatedBooks"
            :key="book.id"
            class="bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden cursor-pointer"
            @click="goToDetail(book.id)"
          >
            <div class="p-6">
              <div class="flex items-start justify-between mb-4">
                <div class="flex-1 mr-3 min-w-0">
                  <h3 class="text-xl font-semibold text-gray-900 line-clamp-1">{{ book.title }}</h3>
                </div>
                <div class="flex space-x-2 flex-shrink-0" @click.stop>
                  <NuxtLink
                    :to="`/books/${book.id}/edit`"
                    class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 text-sm font-medium rounded-full hover:bg-green-200 transition-colors duration-200"
                  >
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    編集
                  </NuxtLink>
                  <button
                    @click="deleteBook(book.id)"
                    class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 text-sm font-medium rounded-full hover:bg-red-200 transition-colors duration-200"
                  >
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    削除
                  </button>
                </div>
              </div>
              
              <div class="flex items-center text-sm text-gray-500 mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{ formatDate(book.read_date) }}
              </div>
              
              <p class="text-gray-700 line-clamp-2 leading-relaxed">{{ book.impression }}</p>
            </div>
          </div>
        </div>

        <!-- ページネーション -->
        <div v-if="totalPages > 1" class="mt-12 flex justify-center">
          <nav class="flex items-center space-x-2">
            <!-- 前のページ -->
            <button
              @click="goToPage(currentPage - 1)"
              :disabled="currentPage === 1"
              class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
            </button>

            <!-- ページ番号 -->
            <template v-for="page in visiblePages">
              <button
                v-if="page !== '...'"
                :key="page"
                @click="goToPage(page)"
                :class="[
                  'px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200',
                  page === currentPage
                    ? 'bg-blue-600 text-white'
                    : 'text-gray-700 bg-white border border-gray-300 hover:bg-gray-50'
                ]"
              >
                {{ page }}
              </button>
              <span v-else :key="`ellipsis-${page}`" class="px-4 py-2 text-gray-500">...</span>
            </template>

            <!-- 次のページ -->
            <button
              @click="goToPage(currentPage + 1)"
              :disabled="currentPage === totalPages"
              class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </button>
          </nav>
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
      loading: true,
      currentPage: 1,
      itemsPerPage: 10
    }
  },
  computed: {
    totalBooks() {
      return this.books.length
    },
    totalPages() {
      return Math.ceil(this.books.length / this.itemsPerPage)
    },
    paginatedBooks() {
      const start = (this.currentPage - 1) * this.itemsPerPage
      const end = start + this.itemsPerPage
      return this.books.slice(start, end)
    },
    visiblePages() {
      const pages = []
      const maxVisible = 5
      
      if (this.totalPages <= maxVisible) {
        for (let i = 1; i <= this.totalPages; i++) {
          pages.push(i)
        }
      } else {
        if (this.currentPage <= 3) {
          for (let i = 1; i <= 4; i++) {
            pages.push(i)
          }
          pages.push('...')
          pages.push(this.totalPages)
        } else if (this.currentPage >= this.totalPages - 2) {
          pages.push(1)
          pages.push('...')
          for (let i = this.totalPages - 3; i <= this.totalPages; i++) {
            pages.push(i)
          }
        } else {
          pages.push(1)
          pages.push('...')
          for (let i = this.currentPage - 1; i <= this.currentPage + 1; i++) {
            pages.push(i)
          }
          pages.push('...')
          pages.push(this.totalPages)
        }
      }
      
      return pages
    }
  },
  async fetch() {
    try {
      if (this.$auth) {
        const response = await this.$auth.apiRequest('/api/books')
        this.books = response.books || []
      }
    } catch (error) {
      console.error('読書ログの取得に失敗しました:', error)
      this.books = []
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
    goToPage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page
        // ページトップにスクロール
        window.scrollTo({ top: 0, behavior: 'smooth' })
      }
    },
    goToDetail(id) {
      this.$router.push(`/books/${id}`)
    },
    async deleteBook(id) {
      if (confirm('この読書ログを削除しますか？')) {
        try {
          if (this.$auth) {
            await this.$auth.apiRequest(`/api/books/${id}`, { method: 'DELETE' })
            this.books = this.books.filter(book => book.id !== id)
            alert('読書ログを削除しました')
            
            // 現在のページが空になった場合、前のページに移動
            if (this.paginatedBooks.length === 0 && this.currentPage > 1) {
              this.currentPage--
            }
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

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  word-break: break-word;
  line-height: 1.4;
  max-height: 2.8em;
}

.line-clamp-4 {
  display: -webkit-box;
  -webkit-line-clamp: 4;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  word-break: break-word;
  line-height: 1.5;
  max-height: 6em;
}
</style>
