import Cookies from 'js-cookie'

export default ({ redirect, app }) => {
  // 認証関連のメソッドをグローバルに追加
  app.$auth = {
    register: async (userData) => {
      try {
        const response = await fetch('/api/auth/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(userData)
        })
        
        if (!response.ok) {
          throw new Error('Registration failed')
        }
        
        return await response.json()
      } catch (error) {
        throw error
      }
    },
    
    login: async (credentials) => {
      try {
        const response = await fetch('/api/login', {
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
        return data
      } catch (error) {
        throw error
      }
    },
    
    logout: async () => {
      try {
        const token = Cookies.get('auth_token')
        await fetch('/api/logout', {
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
        redirect('/login')
      }
    },
    
    getUser: async () => {
      try {
        const token = Cookies.get('auth_token')
        const response = await fetch('/api/user', {
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
      
      const response = await fetch(url, {
        ...defaultOptions,
        ...options
      })
      
      if (!response.ok) {
        throw new Error(`API request failed: ${response.status}`)
      }
      
      return response.json()
    }
  }
}
