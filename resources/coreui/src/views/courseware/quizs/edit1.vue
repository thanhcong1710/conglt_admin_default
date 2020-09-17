<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <loader :active="loading.processing" :text="loading.text" />
          <div class="card-header">
            <strong>Cập nhật câu hỏi</strong>
          </div>
          <div class="card-body">
            <form action method="post">
              <div class="row">
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="nf-email">Dạng câu hỏi</label>
                    <select class="form-control" v-model="quiz.type" disabled>
                      <option value="1">Trắc nghiệm</option>
                      <option value="2">Điền từ</option>
                      <option value="3">Tự luận</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="nf-email">Mã câu hỏi</label>
                    <input class="form-control" type="text" name="title" v-model="quiz.ma_cauhoi" />
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="nf-email">Độ khó</label>
                    <select class="form-control" v-model="quiz.dokho_quiz">
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
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="nf-email">Giao diện hiển thị</label>
                    <select class="form-control" v-model="quiz.noidung_template">
                      <option value="small">Lựa chọn ngắn</option>
                      <option value="large">Lựa chọn dài</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="nf-email">Lọai trắc nghiệm</label>
                    <select class="form-control" v-model="quiz.noidung_is_multichoice">
                      <option value="0">Một đáp án</option>
                      <option value="1">Nhiều đáp án</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="nf-email">Nội dung câu hỏi</label>
                <editor
                  :api-key="tinymce.key"
                  :init="tinymce.init"
                  :value="quiz.noidung_intro"
                  id="noidung_intro"
                />
              </div>
              <div class="form-group">
                <label for="nf-email">Các lựa chọn</label>
                <editor
                  :api-key="tinymce.key"
                  :init="tinymce.init"
                  :value="quiz.noidung_option"
                  id="noidung_option"
                />
                <p style="font-size:12px">
                  <i>Chú ý: lựa chọn có dạng " 1) nội dung lựa chọn 1"</i>
                </p>
              </div>
              <div class="form-group">
                <label for="nf-email">Đáp án</label>
                <input class="form-control" type="text" name="title" v-model="quiz.dapan_quiz" />
                <p style="font-size:12px">
                  <i>Chú ý: đáp án có dạng: 1,2,3</i>
                </p>
              </div>
              <div class="form-group">
                <label for="nf-email">Giải thích</label>
                <editor
                  :api-key="tinymce.key"
                  :init="tinymce.init"
                  :value="quiz.giaithich_quiz"
                  id="giaithich_quiz"
                />
              </div>
            </form>
          </div>
          <div class="card-footer">
            <router-link class="btn btn-danger" :to="`/quizs`">
              <i class="fas fa-undo-alt"></i> Hủy
            </router-link>
            <button class="btn btn-success" type="button" @click="save">
              <i class="fas fa-save"></i> Lưu
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
          entity_encoding: "raw",
          height: 250,
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
        body: "Thêm mới câu hỏi thành công",
        closeOnBackdrop: false,
      },
      quiz: {
        type: 1,
        ma_cauhoi: "",
        status: 1,
        dokho_quiz: 2,
        noidung_template: "large",
        noidung_is_multichoice: 0,
        noidung_intro: "",
        noidung_option: "",
        dapan_quiz: "",
        giaithich_quiz: "",
      },
    };
  },
  created() {
    axios
      .get(
        `api/courseware/quizs/detail/${this.$route.params.id}?token=` +
          localStorage.getItem("api_token")
      )
      .then((response) => {
        this.loading.processing = false;
        this.quiz = response.data;
        this.quiz.noidung_template = this.quiz.noidung_quiz.template
        this.quiz.noidung_is_multichoice = this.quiz.noidung_quiz.is_multichoice
        this.quiz.noidung_intro = this.quiz.noidung_quiz.intro
        this.quiz.noidung_option = this.quiz.noidung_quiz.option_html
      })
      .catch((e) => {
        u.processAuthen(e);
      });
  },
  methods: {
    save() {
      this.loading.processing = true;
      this.quiz.noidung_intro = tinymce.get("noidung_intro").getContent();
      this.quiz.noidung_option = tinymce.get("noidung_option").getContent();
      this.quiz.giaithich_quiz = tinymce.get("giaithich_quiz").getContent();
      axios
        .post(
          `/api/courseware/quizs/update1/${this.$route.params.id}?token=` +
            localStorage.getItem("api_token"),
          this.quiz
        )
        .then((response) => {
          this.loading.processing = false;
          if (response.status == 200) {
            this.modal.color = "success";
            this.modal.body = "Cập nhật câu hỏi thành công";
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
