<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <loader :active="loading.processing" :text="loading.text" />
          <div class="card-header">
            <strong>Câu Hỏi</strong>
          </div>
          <div class="card-body" v-html="this.quiz.noidung_quiz.intro"></div>
          <div class="card-footer">
            <router-link class="btn btn-danger" :to="`/quizs`">
              <i class="fas fa-undo-alt"></i> Quay lại
            </router-link>
          </div>
        </div>
      </div>
    </div>
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
        body: "Thêm mới câu hỏi thành công",
        closeOnBackdrop: false,
      },
      quiz: {
        type: 1,
        ma_cauhoi: "",
        status: 1,
        dokho_quiz: 2,
        noidung_intro: "",
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
      })
      .catch((e) => {
        u.processAuthen(e);
      });
  },
  methods: {
  },
};
</script>
