<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <loader :active="loading.processing" :text="loading.text" />
          <div class="card-header">
            <strong>Bộ lọc</strong>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="form-group col-sm-4">
                <label for="name">Mã câu hỏi</label>
                <input
                  class="form-control"
                  v-model="searchData.keyword"
                  type="text"
                  placeholder="Nhập mã câu hỏi"
                />
              </div>
              <div class="form-group col-sm-4">
                <label for="ccmonth">Trạng thái</label>
                <select class="form-control" v-model="searchData.status">
                  <option value>Chọn trạng thái</option>
                  <option value="0">Ngừng hoạt động</option>
                  <option value="1">Hoạt động</option>
                </select>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <router-link class="btn btn-sm btn-success" :to="'/quizs/add1'">
              <i class="fa fa-plus"></i> Thêm mới
            </router-link>
            <button class="btn btn-sm btn-info" type="submit" @click="search()">
              <i class="fa fa-search"></i> Tìm kiếm
            </button>
            <button
              class="btn btn-sm btn-secondary"
              type="reset"
              @click="reset()"
            >
              <i class="fas fa-undo-alt"></i> Reset
            </button>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="card">
          <loader :active="loading.processing" :text="loading.text" />
          <div class="card-header">
            <strong>Danh sách</strong>
          </div>
          <div class="card-body">
            <table class="table table-responsive-sm">
              <thead>
                <tr>
                  <th>STT</th>
                  <th>Mã câu hỏi</th>
                  <th>Nội dung</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in quizs" :key="index">
                  <td>
                    {{ index + 1 + (pagination.cpage - 1) * pagination.limit }}
                  </td>
                  <td>{{ item.ma_cauhoi }}</td>
                  <td v-html="item.noidung_quiz.intro"></td>
                  <td>{{ item.status | getStatusName }}</td>
                  <td>
                    <router-link
                      class="btn btn-sm btn-success"
                      :to="`/quizs/${item.id}/edit${item.type}`"
                    >
                      <i class="fa fa-edit"></i> Sửa
                    </router-link>
                    <button class="btn btn-sm btn-danger" type="submit">
                      <i class="fas fa-times"></i> Xóa
                    </button>
                    <router-link
                      class="btn btn-sm btn-info"
                      :to="`/preview/${item.id}/quiz${item.type}`"
                    >
                      <i class="fa fa-eye"></i> Xem trước
                    </router-link>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="text-center">
              <nav aria-label="Page navigation">
                <paging
                  :rootLink="pagination.url"
                  :id="pagination.id"
                  :listStyle="pagination.style"
                  :customClass="pagination.class"
                  :firstPage="pagination.spage"
                  :previousPage="pagination.ppage"
                  :nextPage="pagination.npage"
                  :lastPage="pagination.lpage"
                  :currentPage="pagination.cpage"
                  :pagesItems="pagination.total"
                  :pagesLimit="pagination.limit"
                  :pageList="pagination.pages"
                  :routing="changePage"
                ></paging>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import paging from "../../../components/Pagination";
import u from "../../../utilities/utility";
import loader from "../../../components/Loading";

export default {
  components: {
    loader: loader,
    paging: paging,
  },
  name: "List-Product",
  data() {
    return {
      loading: {
        text: "Đang tải dữ liệu...",
        processing: false,
      },
      searchData: {
        keyword: "",
        status: "",
      },
      quizs: [],
      pagination: {
        url: "/api/courseware/quizs/list",
        id: "",
        style: "line",
        class: "",
        spage: 1,
        ppage: 1,
        npage: 0,
        lpage: 1,
        cpage: 1,
        total: 0,
        limit: 20,
        limitSource: [10, 20, 30, 40, 50],
        pages: [],
      },
    };
  },
  created() {
    this.search();
  },
  methods: {
    reset() {
      location.reload();
    },
    search(a) {
      const data = {
        keyword: this.searchData.keyword,
        status: this.searchData.status,
      };
      const link = "/api/courseware/quizs/list";

      this.loading.processing = true;
      u.p(link, data)
        .then((response) => {
          this.loading.processing = false;
          this.quizs = response.data.list;
          this.pagination.spage = response.data.paging.spage;
          this.pagination.ppage = response.data.paging.ppage;
          this.pagination.npage = response.data.paging.npage;
          this.pagination.lpage = response.data.paging.lpage;
          this.pagination.cpage = response.data.paging.cpage;
          this.pagination.total = response.data.paging.total;
          this.pagination.limit = response.data.paging.limit;
        })
        .catch((e) => {});
    },
    changePage(link) {
      const info = link
        .toString()
        .substr(this.pagination.url.length)
        .split("/");
      const page = info.length > 1 ? info[1] : 1;
      this.pagination.cpage = parseInt(page);
      this.search();
    },
  },
  filters: {
    getStatusName(value) {
      return value == 1 ? "Hoạt động" : "Ngừng hoạt động";
    },
  },
};
</script>
