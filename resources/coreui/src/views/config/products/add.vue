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
              <div class="form-group">
                <label for="nf-email">Ghi chú</label>
                <editor :api-key="tinymce.key" :init="tinymce.init" id="input_tinymce" />
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
      product: {
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
      this.product.note = tinymce.get("input_tinymce").getContent();
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
