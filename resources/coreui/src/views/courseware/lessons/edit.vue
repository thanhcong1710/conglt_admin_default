<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <loader :active="loading.processing" :text="loading.text" />
          <div class="card-header">
            <strong>Cập nhật bài học</strong>
          </div>
          <div class="card-body">
            <form action method="post">
              <div class="form-group">
                <label for="nf-email"
                  >Khóa học <span class="text-danger"> (*)</span></label
                >
                <select class="form-control" v-model="lesson.course_id">
                  <option value="">Chọn khóa học</option>
                  <option
                    :value="course.id"
                    v-for="(course, index) in list_course"
                    :key="index"
                  >
                    {{ course.title }}
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label for="nf-email">Tên bài học</label>
                <input
                  class="form-control"
                  type="text"
                  name="title"
                  v-model="lesson.title"
                />
              </div>
              <div class="form-group">
                <label for="nf-email">Ghi chú</label>
                <editor
                  :api-key="tinymce.key"
                  :init="tinymce.init"
                  id="input_tinymce"
                  :value="lesson.description"
                />
              </div>
              <div class="form-group">
                <label for="nf-email">Trạng thái</label>
                <select class="form-control" v-model="lesson.status">
                  <option value="0">Ngừng hoạt động</option>
                  <option value="1">Hoạt động</option>
                </select>
              </div>
            </form>
          </div>
          <div class="card-footer">
            <router-link class="btn btn-danger" :to="`/lessons`">
              <i class="fas fa-undo-alt"></i> Hủy
            </router-link>
            <button class="btn btn-success" type="button" @click="save">
              <i class="fas fa-save"></i> Cập nhật
            </button>
          </div>
        </div>
      </div>
    </div>
    <CModal
      :title="modal.title"
      :show.sync="modal.show"
      :color="modal.color"
      :closeOnBackdrop="modal.closeOnBackdrop"
    >
      {{ modal.body }}
      <template #header>
        <h5 class="modal-title">{{ modal.title }}</h5>
      </template>
      <template #footer>
        <CButton :color="'btn btn-' + modal.color" @click="exit" type="button"
          >Đóng</CButton
        >
      </template>
    </CModal>
  </div>
</template>

<script>
import u from "../../../utilities/utility";
import loader from "../../../components/Loading";
import Editor from "@tinymce/tinymce-vue";

export default {
  components: {
    loader: loader,
    editor: Editor,
  },
  name: "Edit-Product",
  data() {
    return {
      tinymce: {
        key: "68xdyo8hz3oyr5p47zv3jyvj3h6xg0hc0khthuj123tnskcx",
        init: {
          entity_encoding: "raw",
          height: 300,
          menubar: true,
          plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table paste code help wordcount",
          ],
          toolbar:
            "undo redo | bold italic backcolor | image| media |\
           alignleft aligncenter alignright alignjustify | \
           bullist numlist outdent indent | removeformat | help",
          images_upload_url:
            "/api/upload/upload_file?token=" +
            localStorage.getItem("api_token"),
          images_upload_base_path: "",
        },
      },
      loading: {
        text: "Đang tải dữ liệu...",
        processing: false,
      },
      modal: {
        title: "THÔNG BÁO",
        show: false,
        color: "success",
        body: "Cập nhật bài học thành công",
        closeOnBackdrop: false,
      },
      lesson: {
        title: "",
        status: 1,
        lang: 0,
      },
      list_course: [],
    };
  },
  created() {
    this.loading.processing = true;
     u.g("/api/courses/get_all")
      .then((response) => {
        this.loading.processing = false;
        this.list_course = response.data;
      })
      .catch((e) => {});
    this.loading.processing = true;
    u.g(`api/lessons/detail/${this.$route.params.id}`)
      .then((response) => {
        this.loading.processing = false;
        this.lesson = response.data;
      })
      .catch((e) => {});
  },
  methods: {
    save() {
      this.loading.processing = true;
      this.lesson.description = tinymce.get("input_tinymce").getContent();
      u.p(`/api/lessons/update/${this.$route.params.id}`, this.lesson)
        .then((response) => {
          this.loading.processing = false;
          if (response.status == 200) {
            this.modal.color = "success";
            this.modal.body = "Cập nhật bài học thành công";
            this.modal.show = true;
          }
        })
        .catch((e) => {});
    },
    exit() {
      this.$router.push({ path: "/lessons" });
    },
  },
};
</script>
