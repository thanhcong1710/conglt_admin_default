import u from '../../utilities/utility'
const ProductList = () => import('../../views/config/products/list')
const ProductAdd = () => import('../../views/config/products/add')
const ProductEdit = () => import('../../views/config/products/edit')
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
      },
      {
        path: '/products/add',
        name: 'Thêm Mới Sản Phẩm',
        component: ProductAdd
      },
      {
        path: '/products/:id/edit',
        name: 'Cập Nhật Sản Phẩm',
        component: ProductEdit
      }
    ]
  }
}
