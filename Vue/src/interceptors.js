import axios from 'axios';
import store from './store.js'

export default function setup() {
    axios.interceptors.response.use(
        response => response,
        error => {
            const {status} = error.response;
            if (status === 401) {
              localStorage.clear();
            }
            return Promise.reject(error);
       }
      );
}