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
const CourseList = () => import('../../views/courseware/courses/list')
const CourseAdd = () => import('../../views/courseware/courses/add')
const CourseEdit = () => import('../../views/courseware/courses/edit')
const LessonList = () => import('../../views/courseware/lessons/list')
const LessonAdd = () => import('../../views/courseware/lessons/add')
const LessonEdit = () => import('../../views/courseware/lessons/edit')
const TestList = () => import('../../views/courseware/tests/list')
const TestAdd = () => import('../../views/courseware/tests/add')
const TestEdit = () => import('../../views/courseware/tests/edit')

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
      {
        path: '/courses',
        name: 'Danh Sách Khóa Học',
        component: CourseList
      },
      {
        path: '/courses/add',
        name: 'Thêm Mới Khóa Học',
        component: CourseAdd
      },
      {
        path: '/courses/:id/edit',
        name: 'Cập Nhật Khóa Học',
        component: CourseEdit
      },
      {
        path: '/lessons',
        name: 'Danh Sách Bài Học',
        component: LessonList
      },
      {
        path: '/lessons/add',
        name: 'Thêm Mới Bài Học',
        component: LessonAdd
      },
      {
        path: '/lessons/:id/edit',
        name: 'Cập Nhật Bài Học',
        component: LessonEdit
      },
      {
        path: '/tests',
        name: 'Danh Sách Bài Kiểm Tra',
        component: TestList
      },
      {
        path: '/tests/add',
        name: 'Thêm Mới Bài Kiểm Tra',
        component: TestAdd
      },
      {
        path: '/tests/:id/edit',
        name: 'Cập Nhật Bài Kiểm Tra',
        component: TestEdit
      },
    ]
  }
}
