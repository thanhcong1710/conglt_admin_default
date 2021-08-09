<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <loader :active="loading.processing" :text="loading.text" />
          <div class="card-header">
            <strong>Thêm mới buổi học</strong>
          </div>
          <div class="card-body">
            <form action method="post">
              <div class="form-group">
                <label for="nf-email"
                  >Lớp Học <span class="text-danger"> (*)</span></label
                >
                <search
                  :displayIcon="search.loading"
                  :endpoint="search.from_link"
                  :disabled="search.disabled"
                  :suggestObjects="search.from_search"
                  :onSelectObject="search.from_load"
                >
                </search>
              </div>
              <div class="form-group">
                <label for="nf-email">Ngày Học <span class="text-danger"> (*)</span></label>
                <datepicker
                  class="form-control calendar"
                  v-model="lms_schedule.date"
                  placeholder="Chọn ngày học"
                  lang="lang"
                  @change="selectDate"
                />
              </div>
              <div class="form-group">
                <label for="nf-email">Thời gian bắt đầu <span class="text-danger"> (*)</span></label>
                <timepicker format="HH:mm" v-model="lms_schedule.start_time"></timepicker>
              </div>
              <div class="form-group">
                <label for="nf-email">Thời gian kết thúc<span class="text-danger"> (*)</span></label>
                <timepicker format="HH:mm" v-model="lms_schedule.end_time"></timepicker>
              </div>
            </form>
          </div>
          <div class="card-footer">
            <router-link class="btn btn-danger" :to="`/schedules`">
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
import timepicker from "vue2-timepicker";
import moment from 'moment';

export default {
  components: {
    loader: loader,
    editor: Editor,
    vue_select,
    search,
    datepicker,
    timepicker
  },
  name: "Add-Product",
  data() {
    return {
      loading: {
        text: "Đang tải dữ liệu...",
        processing: false,
      },
      modal: {
        title: "THÔNG BÁO",
        show: false,
        color: "success",
        body: "Thêm mới buổi học thành công",
        closeOnBackdrop: false,
        action_exit: "exit",
      },
      lms_schedule: {
        class_id: "",
        date: "",
        start_time: "",
        end_time: "",
      },
      search: {
        loading: "hidden",
        from_link: 0,
        from_search: (keyword) => this.searchSuggest(keyword),
        from_load: (object) => this.searchSelect(object),
        calling: false,
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
      .catch((e) => {
        u.processAuthen(e);
      });
  },
  methods: {
    selectDate(date) {
      if (date) {
        this.lms_schedule.date = moment(date).format("YYYY-MM-DD");
      }
    },
    searchSuggest(keyword) {
      if (keyword && keyword.length > 3 && this.search.calling === false) {
        keyword = keyword.trim();
        keyword = keyword.replace(/[~`!#$%^&*[,\]./<>?;'\\:"|\t]/gi, "");
        this.search.loading = "display";
        this.search.calling = true;
        return new Promise((resolve, reject) => {
          u.g(`/api/config/classes/get_data_by_keyword/${keyword}`)
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
      this.lms_schedule.class_id = obj.id == undefined ? "" : obj.id
    },
    save() {
      let mess = "";
      let resp = true;
      console.log(this.lms_schedule);
      resp = false;
      if (this.lms_schedule.product_id == "") {
        mess += " - Sản phẩm không được để trống<br/>";
        resp = false;
      }
      if (this.lms_schedule.title == "") {
        mess += " - Tên buổi học không được để trống<br/>";
        resp = false;
      }
      if (this.lms_schedule.teacher_id == "") {
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
      this.lms_schedule.note = tinymce.get("input_tinymce").getContent();
      this.loading.processing = true;
      u.p("/api/config/classes/add", this.lms_schedule)
        .then((response) => {
          this.loading.processing = false;
          if (response.status == 200) {
            this.modal.color = "success";
            this.modal.body = "Thêm mới buổi học thành công";
            this.modal.show = true;
            this.modal.action_exit = "exit";
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
  },
};
</script>
<style>
  @import '~vue2-timepicker/dist/VueTimepicker.css';
</style>
