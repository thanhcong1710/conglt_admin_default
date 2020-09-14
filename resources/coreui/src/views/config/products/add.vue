<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <loader :active="loading.processing" :text="loading.text" />
          <div class="card-header">
            <strong>Thêm mới sản phẩm</strong>
          </div>
          <div class="card-body">
            <form action method="post">
              <div class="form-group">
                <label for="nf-email">Tên sản phẩm</label>
                <input class="form-control" type="text" name="title" v-model="product.title" />
              </div>
              <div class="form-group">
                <label for="nf-email">Ngôn ngữ</label>
                <select class="form-control" v-model="product.lang">
                  <option value="0">Tiếng Việt</option>
                  <option value="1">Tiếng Anh</option>
                </select>
              </div>
              <div class="form-group">
                <label for="nf-email">Trạng thái</label>
                <select class="form-control" v-model="product.status">
                  <option value="0">Ngừng hoạt động</option>
                  <option value="1">Hoạt động</option>
                </select>
              </div>
            </form>
          </div>
          <div class="card-footer">
            <router-link class="btn btn-danger" :to="`/products`">
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
        body: "Thêm mới sản phẩm thành công",
        closeOnBackdrop: false,
      },
      product: {
        title: "",
        status: 1,
        lang: 0,
      },
    };
  },
  created() {},
  methods: {
    save() {
      this.loading.processing = true;
      axios
        .post(
          "/api/config/products/add?token=" + localStorage.getItem("api_token"),
          this.product
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
      this.$router.push({ path: "/products" });
    },
  },
};
</script>
