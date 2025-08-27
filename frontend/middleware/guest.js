export default function ({ redirect, app }) {
  // サーバーサイドでは認証チェックをスキップ
  if (process.server) {
    return
  }
  
  // クライアントサイドでのみ認証状態をチェック
  if (process.client && app.$auth && app.$auth.isAuthenticated()) {
    return redirect('/')
  }
}
