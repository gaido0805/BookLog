import Cookies from 'js-cookie'

export default function ({ redirect }) {
  const token = Cookies.get('auth_token')
  if (!token) {
    return redirect('/login')
  }
}
