import u from '../../utilities/utility'
const QuizList = () => import('../../views/courseware/quizs/list')
const QuizAdd1 = () => import('../../views/courseware/quizs/add1')
const QuizEdit1 = () => import('../../views/courseware/quizs/edit1')
const QuizAdd2 = () => import('../../views/courseware/quizs/add2')
const QuizEdit2 = () => import('../../views/courseware/quizs/edit2')
const QuizAdd3 = () => import('../../views/courseware/quizs/add3')
const QuizEdit3 = () => import('../../views/courseware/quizs/edit3')
const PreviewQuiz1 = () => import('../../views/courseware/preview/quiz1')
const PreviewQuiz2 = () => import('../../views/courseware/preview/quiz2')
const PreviewQuiz3 = () => import('../../views/courseware/preview/quiz3')

export default {
  router: {
    path: '/',
    name: 'Nội Dung',
    component: {
      render (c) {
        return c('router-view')
      }
    },
    children: [
      {
        path: '/quizs',
        name: 'Danh Sách Câu Hỏi',
        component: QuizList
      },
      {
        path: '/quizs/add1',
        name: 'Thêm Mới Câu Hỏi',
        component: QuizAdd1
      },
      {
        path: '/quizs/:id/edit1',
        name: 'Cập Nhật Câu Hỏi',
        component: QuizEdit1
      },
      {
        path: '/quizs/add2',
        name: 'Thêm Mới Câu Hỏi',
        component: QuizAdd2
      },
      {
        path: '/quizs/:id/edit2',
        name: 'Cập Nhật Câu Hỏi',
        component: QuizEdit2
      },
      {
        path: '/quizs/add3',
        name: 'Thêm Mới Câu Hỏi',
        component: QuizAdd3
      },
      {
        path: '/quizs/:id/edit3',
        name: 'Cập Nhật Câu Hỏi',
        component: QuizEdit3
      },
      {
        path: '/preview/:id/quiz1',
        name: 'Xem Trước Câu Hỏi',
        component: PreviewQuiz1
      },
      {
        path: '/preview/:id/quiz2',
        name: 'Xem Trước Câu Hỏi',
        component: PreviewQuiz2
      },
      {
        path: '/preview/:id/quiz3',
        name: 'Xem Trước Câu Hỏi',
        component: PreviewQuiz3
      },
    ]
  }
}
