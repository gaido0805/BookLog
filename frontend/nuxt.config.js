export default {
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'BookLog - 読書ログ管理システム',
    htmlAttrs: {
      lang: 'ja'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '読んだ本のタイトルと読んだ日、読んだ感想が保存できるサイト' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    '~/plugins/auth.js'
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    '@nuxtjs/tailwindcss'
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
  ],

  // Server configuration for Docker
  server: {
    host: '0.0.0.0',
    port: 3000
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  }
}
