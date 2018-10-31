import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    status: '',
    token: localStorage.getItem('token'),
    user : localStorage.getItem('user')
  },
  mutations: {
    auth_request(state){
      state.status = 'loading'
    },
    auth_success(state, token, user){
      state.status = 'success'
      state.token = token
      state.user = user
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
            const token = resp.data.token
            const user = resp.data.user
            //console.log(user)
            localStorage.setItem('token', token) //store the token
            localStorage.setItem('user',JSON.stringify(user)) //store the user in stringified json
            axios.defaults.headers.common['Authorization'] = token //set the token header
            //console.log(axios.defaults.headers.common['Authorization'])
            commit('auth_success', token, user)
            resolve(resp)
          })
          .catch(err => {
            commit('auth_error')
            localStorage.removeItem('token')
            localStorage.removeItem('user')
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