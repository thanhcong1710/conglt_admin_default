import u from '../../utilities/utility'
const ProductList = () => import('../../views/config/products/list')
export default {
  router: {
    path: '/',
    name: 'Hệ Thống',
    component: {
      render (c) {
        return c('router-view')
      }
    },
    children: [
      {
        path: '/products',
        name: 'Danh Sách Các Sản Phẩm',
        component: ProductList
      }
      // routers.product_add,
      // routers.product_edit,
    ]
  }
}
