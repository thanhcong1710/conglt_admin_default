<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <loader :active="loading.processing" :text="loading.text" />
          <div class="card-header">
            <strong>Cập nhật lớp học</strong>
          </div>
          <div class="card-body">
            <form action method="post">
              <div class="form-group">
                <label for="nf-email"
                  >Sản phẩm <span class="text-danger"> (*)</span></label
                >
                <select class="form-control" v-model="lms_class.product_id">
                  <option value="">Chọn sản phẩm</option>
                  <option
                    :value="product.id"
                    v-for="(product, index) in list_product"
                    :key="index"
                  >
                    {{ product.title }}
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label for="nf-email"
                  >Tên lớp học <span class="text-danger"> (*)</span></label
                >
                <input
                  class="form-control"
                  type="text"
                  name="title"
                  v-model="lms_class.title"
                />
              </div>
              <div class="form-group">
                <label for="nf-email">Lịch học </label>
                <vue_select
                  label="title"
                  multiple
                  :options="list_shift"
                  v-model="lms_class.shift_selected"
                  placeholder="Chọn lịch học"
                  :searchable="true"
                  language="en-US"
                ></vue_select>
              </div>
              <div class="form-group">
                <label for="nf-email">Ngày bắt đầu</label>
                <datepicker
                  class="form-control calendar"
                  v-model="lms_class.start_date"
                  placeholder="Chọn ngày bắt đầu"
                  lang="lang"
                  @change="selectDate"
                />
              </div>
              <div class="form-group">
                <label for="nf-email">Số buổi học</label>
                <input
                  class="form-control"
                  type="number"
                  name="title"
                  v-model="lms_class.session"
                />
              </div>
              <div class="form-group">
                <label for="nf-email"
                  >Giáo viên <span class="text-danger"> (*)</span></label
                >
                <search
                  :displayIcon="search.loading"
                  :endpoint="search.from_link"
                  :disabled="search.disabled"
                  :suggestObjects="search.from_search"
                  :onSelectObject="search.from_load"
                  :placeholderObject="search.placeholder"
                >
                </search>
              </div>
              <div class="form-group">
                <label for="nf-email">Ghi chú</label>
                <editor
                  :api-key="tinymce.key"
                  :init="tinymce.init"
                  id="input_tinymce"
                  :value="lms_class.note"
                />
              </div>
              <div class="form-group">
                <label for="nf-email">Trạng thái</label>
                <select class="form-control" v-model="lms_class.status">
                  <option value="0">Ngừng hoạt động</option>
                  <option value="1">Hoạt động</option>
                </select>
              </div>
            </form>
          </div>
          <div class="card-footer">
            <router-link class="btn btn-danger" :to="`/classes`">
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
      <div v-html="modal.body"></div>
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
import vue_select from "vue-select";
import search from "../../../components/ObjectSearch";
import datepicker from "vue2-datepicker";
import moment from 'moment';

export default {
  components: {
    loader: loader,
    editor: Editor,
    vue_select,
    search,
    datepicker
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
        body: "Cập nhật lớp  học thành công",
        closeOnBackdrop: false,
        action_exit: "exit",
      },
      lms_class: {
        title: "",
        status: 1,
        lang: 0,
        note: "",
        product_id: "",
        shift_selected: [],
        teacher_id:"",
        session:0,
        start_date:""
      },
      list_product: [],
      list_shift: [],
      search: {
        loading: "hidden",
        from_link: 0,
        from_search: (keyword) => this.searchSuggest(keyword),
        from_load: (object) => this.searchSelect(object),
        calling: false,
        placeholder:""
      },
    };
  },
  created() {
    this.loading.processing = true;
    u.g("/api/config/products/get_all")
      .then((response) => {
        this.loading.processing = false;
        this.list_product = response.data;
      })
      .catch((e) => {});
    this.loading.processing = true;
    u.g("/api/config/shifts/get_all")
      .then((response) => {
        this.loading.processing = false;
        this.list_shift = response.data;
      })
      .catch((e) => {});
    this.loading.processing = true;
    u.g(`api/config/classes/detail/${this.$route.params.id}`)
      .then((response) => {
        this.loading.processing = false;
        this.lms_class = response.data;
        this.search.placeholder = this.lms_class.teacher_name;
      })
      .catch((e) => {});
  },
  methods: {
    save() {
      let mess = "";
      let resp = true;
      if (this.lms_class.product_id == "") {
        mess += " - Sản phẩm không được để trống<br/>";
        resp = false;
      }
      if (this.lms_class.title == "") {
        mess += " - Tên lớp học không được để trống<br/>";
        resp = false;
      }
      if (this.lms_class.teacher_id == "") {
        mess += " - Giáo viên không được để trống<br/>";
        resp = false;
      }
      if (!resp) {
        this.modal.color = "danger";
        this.modal.body = mess;
        this.modal.show = true;
        this.modal.action_exit = "close";
        return false;
      }
      this.loading.processing = true;
      this.lms_class.note = tinymce.get("input_tinymce").getContent();
      u.p(`/api/config/classes/update/${this.$route.params.id}`, this.lms_class)
        .then((response) => {
          this.loading.processing = false;
          if (response.status == 200) {
            this.modal.color = "success";
            this.modal.body = "Cập nhật lớp  học thành công";
            this.modal.show = true;
          }
        })
        .catch((e) => {});
    },
    exit() {
      if (this.modal.action_exit == "exit") {
        this.$router.push({ path: "/classes" });
      } else {
        this.modal.show = false;
      }
    },
    searchSuggest(keyword) {
      if (keyword && keyword.length > 3 && this.search.calling === false) {
        keyword = keyword.trim();
        keyword = keyword.replace(/[~`!#$%^&*[,\]./<>?;'\\:"|\t]/gi, "");
        this.search.loading = "display";
        this.search.calling = true;
        return new Promise((resolve, reject) => {
          u.g(`/api/config/teachers/get_data_by_keyword/${keyword}`)
            .then((response) => {
              const resp = response.data.length
                ? response.data
                : [
                    {
                      label: "Không tìm thấy kết quả nào phù hợp",
                      student_name: "Không có kết quả nào phù hợp",
                    },
                  ];
              this.search.calling = false;
              this.search.loading = "hidden";
              resolve(resp);
            })
            .catch((e) => {
              u.lg(e);
              this.search.loading = "hidden";
            });
        });
      }
    },
    searchSelect(obj) {
      this.lms_class.teacher_id = obj.id == undefined ? "" : obj.id
    },
    selectDate(date) {
      if (date) {
        this.lms_class.start_date = moment(date).format("YYYY-MM-DD");
      }
    },
  },
};
</script>
