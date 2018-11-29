import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import router from './router'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    status: '',
    token_mystery: localStorage.getItem('token_mystery'),
    token: localStorage.getItem('token')? localStorage.getItem('token') : null,
    user : localStorage.getItem('user')? localStorage.getItem('user'): {}
  },
  mutations: {
    auth_request(state){
      state.status = 'loading'
    },
    auth_success(state, token, users){
      state.status = 'success'
      state.token = token
      Vue.set(state, 'user', users)
    },
    auth_error(state){
      state.status = 'error'
    },
    logout(state){
      state.status = ''
      state.token = ''
    },
  },
  actions: {
    login({commit}, user){
        return new Promise((resolve, reject) => {
          commit('auth_request')

          axios({url: 'api/login', data: user, method: 'POST' })
          .then(resp => {
            const status = resp.data.status
            const token = resp.data.token
            const user = resp.data.user
            if(resp.data.status !== 200){
              alert("电子邮件或密码输入错误！")
              router.push('login')
            }else{
              const token = resp.data.token
              const user = resp.data.user
              const token_mystery = resp.data.token_mystery
              //console.log(user)
              localStorage.setItem('token', token) //store the token
              localStorage.setItem('user',JSON.stringify(user)) //store the user in stringified json
              localStorage.setItem('token_mystery', token_mystery)
              axios.defaults.headers.common['Authorization'] = token //set the token header
              commit('auth_success', token, user)
              router.push('/');
              resolve(resp)
            }      
          })
          .catch(err => {
            commit('auth_error')
            localStorage.removeItem('token')
            localStorage.removeItem('user')
            localStorage.removeItem('token_mystery')
            reject(err)
          })
        })
    },
    logout({commit}){
        return new Promise((resolve, reject) => {
          commit('logout')
          //console.log(axios.defaults.headers.common['Authorization'])
          axios({url: 'api/logout',headers: {Authorization: "Bearer " + localStorage.getItem('token')}, method: 'POST'})
          .then(resp => {
            //console.log(resp.data.message)
            localStorage.removeItem('token')
            localStorage.removeItem('user')
            delete axios.defaults.headers.common['Authorization']
            resolve()
          }) //may need to connect to backend
        })
      },
  },
  getters : {
    isLoggedIn: state => !!state.token,
    authStatus: state => state.status,
    authUser: state=> state.user
  }
})