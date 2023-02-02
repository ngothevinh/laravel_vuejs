import { createRouter , createWebHistory } from 'vue-router'

//khai báo các router
import CreateComponent from '../components/posts/CreateComponent.vue'
import IndexComponent from '../components/posts/IndexComponent.vue'
import EditComponent from '../components/posts/EditComponent.vue'
import NotFound from '../components/notFound.vue'
import IndexTag from '../components/tag/IndexTag.vue'
import CreateTag from '../components/tag/CreateTag.vue'
import EditTag from '../components/tag/EditTag.vue'
const routes = [
    //post
    {
        name: 'create',
        path: '/create',
        component: CreateComponent,
    },
    {
        name: 'posts',
        path: '/',
        component: IndexComponent,
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: EditComponent,
    },
    {
        path: '/:pathMatch(.*)*',
        component: NotFound
    },
    //tag
    {
        name: 'createTag',
        path: '/tag/create',
        component: CreateTag
    },
    {
        name: 'tag',
        path: '/tag',
        component: IndexTag,
    },
    {
        name: 'editTag',
        path: '/tag/edit/:id',
        component: EditTag,
    },
]
const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
})

export default router
