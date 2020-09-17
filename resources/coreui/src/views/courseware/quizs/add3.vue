<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <loader :active="loading.processing" :text="loading.text" />
          <div class="card-header">
            <strong>Thêm mới câu hỏi</strong>
          </div>
          <div class="card-body">
            <form action method="post">
              <div class="row">
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="nf-email">Mã câu hỏi</label>
                    <input class="form-control" type="text" name="title" v-model="quiz.ma_cauhoi" />
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="nf-email">Dạng câu hỏi</label>
                    <select class="form-control" v-model="quiz.type">
                      <option value="1">Trắc nghiệm</option>
                      <option value="2">Điền từ</option>
                      <option value="3">Tự luận</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="nf-email">Độ khó</label>
                    <select class="form-control" v-model="quiz.status">
                      <option value="1">Dễ</option>
                      <option value="2">Trung bình</option>
                      <option value="3">Khó</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="nf-email">Trạng thái</label>
                    <select class="form-control" v-model="quiz.status">
                      <option value="0">Ngừng hoạt động</option>
                      <option value="1">Hoạt động</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="nf-email">Ghi chú</label>
                <editor :api-key="tinymce.key" :init="tinymce.init" id="input_tinymce" />
              </div>
            </form>
          </div>
          <div class="card-footer">
            <router-link class="btn btn-danger" :to="`/quizs`">
              <i class="fas fa-undo-alt"></i> Hủy
            </router-link>
            <button class="btn btn-success" type="button" @click="save">
              <i class="fas fa-save"></i> Thêm mới
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
      {{modal.body}}
      <template #header>
        <h5 class="modal-title">{{modal.title}}</h5>
      </template>
      <template #footer>
        <CButton :color="'btn btn-'+modal.color" @click="exit" type="button">Đóng</CButton>
      </template>
    </CModal>
  </div>
</template>

<script>
import axios from "axios";
import u from "../../../utilities/utility";
import loader from "../../../components/Loading";
import Editor from "@tinymce/tinymce-vue";

export default {
  components: {
    loader: loader,
    editor: Editor,
  },
  name: "Add-Product",
  data() {
    return {
      tinymce: {
        key: "68xdyo8hz3oyr5p47zv3jyvj3h6xg0hc0khthuj123tnskcx",
        init: {
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
        body: "Thêm mới sản phẩm thành công",
        closeOnBackdrop: false,
      },
      quiz: {
        title: "",
        status: 1,
        lang: 0,
        note: "",
      },
    };
  },
  created() {},
  methods: {
    save() {
      this.quiz.note = tinymce.get("input_tinymce").getContent();
      this.loading.processing = true;
      axios
        .post(
          "/api/config/quizs/add?token=" + localStorage.getItem("api_token"),
          this.quiz
        )
        .then((response) => {
          this.loading.processing = false;
          if (response.status == 200) {
            this.modal.color = "success";
            this.modal.body = "Thêm mới sản phẩm thành công";
            this.modal.show = true;
          }
        })
        .catch((e) => {
          u.processAuthen(e);
        });
    },
    exit() {
      this.$router.push({ path: "/quizs" });
    },
  },
};
</script>
