import u from '../../utilities/utility'
const StudentsList = () => import('../../views/students/list')
const StudentsAdd = () => import('../../views/students/add')
const StudentsEdit = () => import('../../views/students/edit')

export default {
  router: {
    path: '/',
    name: 'Vận hành',
    component: {
      render (c) {
        return c('router-view')
      }
    },
    children: [
      {
        path: '/students',
        name: 'Danh Sách Học Sinh',
        component: StudentsList
      },
      {
        path: '/students/add',
        name: 'Thêm Mới Học Sinh',
        component: StudentsAdd
      },
      {
        path: '/students/:id/edit',
        name: 'Cập Nhật Học Sinh',
        component: StudentsEdit
      }
    ]
  }
}
