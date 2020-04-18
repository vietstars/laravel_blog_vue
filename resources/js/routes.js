import Dashboard from './components/admin/Dashboard.vue';
import CategoryList from './components/admin/category/List.vue';
import PostList from './components/admin/post/List.vue';
import Icon from './components/admin/Icon.vue';

export const routes = [
	{ path: '/dashboard', component: Dashboard, name: 'dashboard' },
	{ path: '/category-list', component: CategoryList, name: 'cat-list' },
	{ path: '/post-list', component: PostList, name: 'post-list' },
	{ path: '/icon', component: Icon, name: 'icon-list' }
]
