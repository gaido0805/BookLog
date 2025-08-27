import Cookies from 'js-cookie'

export default function ({ app }, inject) {
  // 認証プラグインが読み込まれました
  
  // APIのベースURL
  const API_BASE_URL = process.env.API_BASE_URL || 'http://localhost:8000'
  
  // 認証状態をリアクティブに管理
  const authState = {
    isAuthenticated: false,
    user: null
  }
  
  // 認証状態変更イベントを発火する関数
  const emitAuthChange = () => {
    if (process.client) {
      window.dispatchEvent(new CustomEvent('auth-state-changed'))
    }
  }
  
  // 認証状態を更新する関数
  const updateAuthState = () => {
    authState.isAuthenticated = !!Cookies.get('auth_token')
    emitAuthChange()
  }
  
  // 認証関連のメソッドをグローバルに追加
  const auth = {
    register: async (userData) => {
      try {
        const response = await fetch(`${API_BASE_URL}/api/auth/register`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(userData)
        })
        
        if (!response.ok) {
          throw new Error('Registration failed')
        }
        
        const data = await response.json()
        const token = data.token
        Cookies.set('auth_token', token, { expires: 7 })
        updateAuthState()
        return data
      } catch (error) {
        throw error
      }
    },
    
    login: async (credentials) => {
      try {
        const response = await fetch(`${API_BASE_URL}/api/auth/login`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(credentials)
        })
        
        if (!response.ok) {
          throw new Error('Login failed')
        }
        
        const data = await response.json()
        const token = data.token
        Cookies.set('auth_token', token, { expires: 7 })
        updateAuthState()
        return data
      } catch (error) {
        console.error('ログインエラー:', error)
        throw error
      }
    },
    
    logout: async () => {
      try {
        const token = Cookies.get('auth_token')
        await fetch(`${API_BASE_URL}/api/auth/logout`, {
          method: 'POST',
          headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
          }
        })
      } catch (error) {
        console.error('Logout error:', error)
      } finally {
        Cookies.remove('auth_token')
        updateAuthState()
        // ログアウト後にログインページにリダイレクト
        if (app.router) {
          app.router.push('/login')
        }
      }
    },
    
    getUser: async () => {
      try {
        const token = Cookies.get('auth_token')
        const response = await fetch(`${API_BASE_URL}/api/auth/user`, {
          headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
          }
        })
        
        if (!response.ok) {
          throw new Error('Failed to get user')
        }
        
        return await response.json()
      } catch (error) {
        throw error
      }
    },
    
    isAuthenticated: () => {
      return !!Cookies.get('auth_token')
    },
    
    getToken: () => {
      return Cookies.get('auth_token')
    },
    
    apiRequest: async (url, options = {}) => {
      const token = Cookies.get('auth_token')
      const defaultOptions = {
        headers: {
          'Content-Type': 'application/json',
          ...(token && { 'Authorization': `Bearer ${token}` }),
          ...options.headers
        }
      }
      
      const response = await fetch(`${API_BASE_URL}${url}`, {
        ...defaultOptions,
        ...options
      })
      
      if (!response.ok) {
        throw new Error(`API request failed: ${response.status}`)
      }
      
      return response.json()
    }
  }

  // inject関数を使用して$authをグローバルに追加
  inject('auth', auth)
}
