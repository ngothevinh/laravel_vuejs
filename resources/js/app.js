require('./bootstrap');

import { createApp } from "vue"
import router from "./router"
import App from "./components/App.vue"
export default {

}

createApp(App).use(router).mount("#app")



